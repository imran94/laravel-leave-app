<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Department;
use App\Designation;
use App\Helpers\EmailPattern;
use App\Helpers\Utils;
use App\Http\Requests\ValidateLeaveApplication;
use App\Mail\LeaveApplication;
use App\LeaveRequest;
use App\Leaves;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

use function auth;
use function env;
use function view;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use PharIo\Manifest\Author;

class LeaveApplicationController extends Controller
{

    //level value 1 means approved by admin and value 2 means approve by HOD/TL
    private $leaveStatus;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('leaveApplication/leaveForm')->with('leave', null);
    }

    //count number of working days between two days
    private function numberOfWorkingDays($from, $to)
    {
        $workingDays = [1, 2, 3, 4, 5]; # date format = N (1 = Monday, 2 = Tuesday ...)

        $from = new \DateTime($from);
        $to = new \DateTime($to);
        //        $to->modify('+1 day');
        $interval = new \DateInterval('P1D');

        $periods = new \DatePeriod($from, $interval, $to);

        $days = 0;
        foreach ($periods as $period) {
            if (!in_array($period->format('N'), $workingDays))
                continue;
            $days++;
        }
        return $days;
    }

    public function store(ValidateLeaveApplication $request)
    {
        if ($request->id == null) {
            $employeeLeaveRequests = LeaveRequest::where([
                ['empId', Auth::user()->id],
                ['return_date', '>=', Carbon::today()]
            ])->get();
            foreach ($employeeLeaveRequests as $leave) {
                if (
                    $leave->status != 5
                    && $request->start_date >= $leave->leaveDate
                    && $request->start_date < $leave->return_date
                ) {
                    return Redirect::back()->withErrors(['errorMessage' => 'You\'ve already applied for leave on this day. Please update the existing request.']);
                }
            }
        }

        // TODO: Move to separate PUT method
        if ($request->id != null && LeaveRequest::find($request->id)->status !== 0) {
            //leave already processed
            return Redirect::back()->withErrors(['errorMessage' => "Your leave has already been processed."]);
        }
        $empId = Auth::user()->id;
        $name = Auth::user()->name;
        $email = Auth::user()->email;
        $time_period = $request->time_period;

        if ($time_period == "AM" || $time_period == "PM") {
            $leaves = 0.5;
            $request->end_date = $time_period == "AM"
                ? $request->start_date
                : date('Y-m-d', strtotime($request->start_date . ' + 1 day'));
        } else {
            if (strtotime($request->start_date) >= strtotime($request->end_date)) {
                return Redirect::back()->withErrors(['errorMessage' => 'Dates are invalid, please provide valid dates']);
            }
            $leaves = $this->numberOfWorkingDays($request->start_date, $request->end_date);
        }

        //check whether leaves is on weekend
        if (((strcmp('Sunday', date("l", strtotime($request->start_date))) == 0)
                || (strcmp('Saturday', date("l", strtotime($request->start_date))) == 0))
            && $leaves < 1
        ) {
            return Redirect::back()->withErrors(['errorMessage' => 'Leave Date cannot be set on a weekend']);
        }

        if ($request->type == 'Annual leave') {
            $annualLeft = Leaves::firstOrCreate(['empId' => $empId, 'year' => now()->year])->annualLeft;
            if ($leaves > (int) $annualLeft) {
                return Redirect::back()->withErrors([
                    'errorMessage' => "The number of days exceed the number of annual leaves available to you. You only have {$annualLeft} annual leaves available."
                ]);
            }
        }

        //valid
        //move dates forward if joining dates are saturday or sunday
        if (strcmp('Saturday', date("l", strtotime($request->end_date))) == 0) {
            $request->end_date = date('Y-m-d', strtotime("+2 days", strtotime($request->end_date)));
        } else if (strcmp('Sunday', date("l", strtotime($request->end_date))) == 0) {
            $request->end_date = date('Y-m-d', strtotime("+1 days", strtotime($request->end_date)));
        }
        //get current date for checking and inserting new record
        $currentDate = date("Y-m-d h:i:s");

        $fileNameToStore = LeaveRequest::where('id', $request->id)->pluck('attachment')->first() ?? "";
        if ($request->hasFile('attachment')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('attachment')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename = str_replace(" ", "-", substr($filename, 0, 20));
            // Get just ext
            $extension = $request->file('attachment')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = Auth::user()->id . "-" . $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('attachment')->storePubliclyAs('leaves', $fileNameToStore);
            $fileNameToStore = "leaves/" . $fileNameToStore;
        }

        $request->reason = str_replace("'", "\'", $request->reason);
        $request->reason = str_replace('"', '\"', $request->reason);
        $newLeaveRequest = LeaveRequest::updateOrCreate(
            ['id' => $request->id],
            [
                'empId' => $empId,
                'name' => $name,
                'leaveDate' => $request->start_date,
                'return_date' => $request->end_date,
                'time_period' => $request->time_period,
                'leaves' => $leaves,
                'reason' => $request->reason,
                'status' => 0,
                'type' => $request->type,
                'lineManagerId' => Auth::user()->tlId,
                'attachment' => $fileNameToStore
            ]
        );

        if (!is_null($newLeaveRequest)) {
            $this->mail($empId, $newLeaveRequest->id, EmailPattern::CREATE);
            return redirect()->route('leave-requests')->with('status', 'Your leave application has been submitted');
        }
        return view('leaveApplication/leaveForm')->with('errorMessage', 'Something went wrong! Your request could not be processed');
    }

    private function mail($empId = null, $leaveId = null, $emailPattern)
    {
        $cc = array();
        $employee = User::find($empId);

        $to = $employee->email;
        array_push($cc, $employee->email);
        $tlId = $employee->tlId;

        $leave = LeaveRequest::find($leaveId);

        $return_date = $leave->return_date;
        $startingDate = $leave->leaveDate;
        $numberOfDays = $leave->leaves;
        $typeOfLeave = $leave->type;
        $reason = $leave->reason;
        $headerName = User::find($leave->empId)->name;
        $tlComment = $leave->comment;
        $applyDate = $leave->created_at;

        $emailToBeSend = env($emailPattern);
        $emailToBeSend = str_replace("%UPDATED_BY%", Auth::user()->name, $emailToBeSend);
        $emailToBeSend = str_replace("%START_DATE%", date("l jS \of F Y", strtotime($startingDate)), $emailToBeSend);
        $emailToBeSend = str_replace("%JOINING_DATE%", date("l jS \of F Y", strtotime($return_date)), $emailToBeSend);
        $emailToBeSend = str_replace("%NUMBER_OF_DAYS%", $numberOfDays, $emailToBeSend);
        $emailToBeSend = str_replace("%TYPE_OF_LEAVE%", $typeOfLeave, $emailToBeSend);
        $emailToBeSend = str_replace("%REASON%", $reason, $emailToBeSend);

        $name = Auth::user()->name;

        $teamLeadEmail = User::find($tlId)?->email;
        if (!is_null($teamLeadEmail)) {
            array_push($cc, $teamLeadEmail);
        }

        $employeeBranchId = $leave->employee->designation->department->branch->id;
        $employeeBranchDepartmentIds = Department::where("branch_id", $employeeBranchId)->pluck('id')->all();
        $employeeBranchDesignationIds = Designation::whereIn("deptId", $employeeBranchDepartmentIds)->pluck('id')->all();
        $employeeBranchAdminEmails = User::whereIn("designationId", $employeeBranchDesignationIds)->where('access_type', 1)->pluck('email')->all();
        $cc = array_merge($cc, $employeeBranchAdminEmails);

        $teamLeadComment = "";
        $adminComment = "";
        if ($leave->status == 2 || $leave->status == 4) { // Approved/disapproved by admin
            // Update Leaves table
            if ($leave->status == 2) {
                $endYear = Carbon::parse($return_date)->year;
                $leaveRecord = Leaves::firstOrCreate(['empId' => $empId, 'year' => $endYear]);
                $updateFields = array();
                if ($typeOfLeave == 'Annual leave') {
                    $updateFields = [
                        'annualAvailed' => $leaveRecord->annualAvailed + $numberOfDays,
                        'annualLeft' => $leaveRecord->annualLeft - $numberOfDays
                    ];
                } else if ($typeOfLeave == 'Sick leave (Illness or Injury)') {
                    $updateFields = [
                        'sickAvailed' => $leaveRecord->sickAvailed + $numberOfDays,
                        'sickLeft' => $leaveRecord->sickLeft - $numberOfDays
                    ];
                } else {
                    $updateFields = [
                        'otherAvailed' => $leaveRecord->otherAvailed + $numberOfDays,
                        'otherLeft' => $leaveRecord->otherLeft - $numberOfDays
                    ];
                }
                Leaves::where(['empId' => $empId, 'year' => $endYear])->update($updateFields);
            }

            $teamLeadComment = "TL/HOD Comment: " . $leave->comment;
            $adminComment = "Admin Comment: " . $leave->adminComment;
        } else if ($leave->status === 1 || $leave->status === 3) { // Approved/disapproved by TL/HOD
            $teamLeadComment = "TL/HOD Comment: " . $leave->comment;
        } else { //employee applied for leave
            $to = $teamLeadEmail ?? $employeeBranchAdminEmails[0];
        }
        $emailToBeSend = str_replace("%LEAD_COMMENT%", $teamLeadComment, $emailToBeSend);
        $emailToBeSend = str_replace("%ADMIN_COMMENT%", $adminComment, $emailToBeSend);
        $emailToBeSend = str_replace("%NAME%", $headerName, $emailToBeSend);

        Mail::to($to)
            ->cc($cc)
            ->send(new LeaveApplication($headerName, $applyDate, $emailToBeSend));
        return 'Email sent Successfully';
    }

    public function approve(Request $request)
    {
        if (Auth::user()->access_type == 1 || Auth::user()->access_type == 0 || Auth::user()->access_type == -1) {
            $request->comment = str_replace("'", "\'", $request->comment);
            $request->comment = str_replace('"', '\"', $request->comment);

            $leaveRequest = LeaveRequest::find($request->id);
            if (is_null($leaveRequest)) {
                return redirect()->route('leave-requests')->withErrors(['errorMessage' => 'Leave request could not be found']);
            }

            if (Auth::user()->access_type == 1) {
                $emailPattern = EmailPattern::APPROVED_BY_ADMIN;
                $leaveRequest->status = 2;
                $leaveRequest->adminComment = $request->comment;
            } else {
                $emailPattern = EmailPattern::APPROVED_BY_TL;
                $leaveRequest->status = 1;
                $leaveRequest->comment = $request->comment;
            }

            if ($leaveRequest->save()) {
                $this->mail($leaveRequest->empId, $request->id, $emailPattern);
                return redirect()->route('leave-requests')->with('status', 'Leave approved successfully');
            }
            return redirect()->route('leave-requests')->withErrors(['errorMessage' => 'Something went wrong! Your approval could not be processed']);
        }
        return back()->withErrors(['errorMessage' => 'You are not authorized to approve leave']);
    }

    public function disapprove(Request $request)
    {
        if (Auth::user()->access_type == 1 || Auth::user()->access_type == 0 || Auth::user()->access_type == -1) {
            $request->comment = str_replace("'", "\'", $request->comment);
            $request->comment = str_replace('"', '\"', $request->comment);

            $leaveRequest = LeaveRequest::find($request->id);
            if (is_null($leaveRequest)) {
                return redirect()->route('leave-requests')->withErrors(['errorMessage' => 'Leave request could not be found']);
            }

            if (Auth::user()->access_type == 1) {
                $emailPattern = EmailPattern::DISAPPROVED_BY_ADMIN;
                $leaveRequest->status = 4;
                $leaveRequest->adminComment = $request->comment;
            } else {
                $emailPattern = EmailPattern::DISAPPROVED_BY_TL;
                $leaveRequest->status = 3;
                $leaveRequest->comment = $request->comment;
            }

            if ($leaveRequest->save()) {
                $this->mail($leaveRequest->empId, $request->id, $emailPattern);
                return redirect()->route('leave-requests')->with('status', 'Leave disapproved successfully');
            }
            return redirect()->route('leave-requests')->withErrors(['errorMessage' => 'Something went wrong! Your disapproval could not be processed']);
        }
        return back()->with('errorMessage', 'Sorry you are not authorized to disapprove leave');
    }

    public function leaveRequests()
    {
        //get all leaves requests
        return view('leaveApplication/leaveRequests', ['leaves' => $this->getLeaveRequests(), 'today' => Carbon::today()]);
    }

    public function leaveRequestsHistory(Request $request)
    {
        $result = LeaveRequest::where([
            ['empId', $request->id],
            ['status', 2]
        ])->whereYear('leaveDate', $request->year)
            ->get();
        return view('leaveApplication/leaveRequestsHistory')->with('leaves', $result);
    }

    public function approveRequest(Request $request)
    {
        if (Auth::user()->access_type == 1 || Auth::user()->access_type == 0 || Auth::user()->access_type == -1) {
            return view('leaveApplication/approveRequestForm')->with('id', $request->id)->with('empId', $request->empId);
        } else {
            return back()->with('errorMessage', 'you are not authorized to view this page');
        }
    }

    public function disapproveRequest(Request $request)
    {
        if (Auth::user()->access_type == 1 || Auth::user()->access_type == 0 || Auth::user()->access_type == -1) {
            return view('leaveApplication/disapproveRequestForm')->with('id', $request->id)->with('empId', $request->empId);
        } else {
            return back()->with('errorMessage', 'You are not authorized to view this page');
        }
    }

    public function deleteLeaveRequest(Request $request)
    {
        $leaveRequest = LeaveRequest::find($request->id);
        if (is_null($leaveRequest)) {
            return redirect()->route('leave-requests')->withErrors(['errorMessage' => 'Leave request not found']);
        }

        if ($leaveRequest->status == 2) {
            $endYear = Carbon::parse($leaveRequest->return_date)->year;
            $leaveRecord = Leaves::firstWhere(['empId' => $leaveRequest->empId, 'year' => $endYear]);
            $updateFields = array();
            if ($leaveRequest->type == 'Annual leave') {
                $updateFields = [
                    'annualAvailed' => $leaveRecord->annualAvailed - $leaveRequest->leaves,
                    'annualLeft' => $leaveRecord->annualLeft + $leaveRequest->leaves
                ];
            } else if ($leaveRequest->type == 'Sick leave (Illness or Injury)') {
                $updateFields = [
                    'sickAvailed' => $leaveRecord->sickAvailed - $leaveRequest->leaves,
                    'sickLeft' => $leaveRecord->sickLeft + $leaveRequest->leaves
                ];
            } else {
                $updateFields = [
                    'otherAvailed' => $leaveRecord->otherAvailed - $leaveRequest->leaves,
                    'otherLeft' => $leaveRecord->otherLeft + $leaveRequest->leaves
                ];
            }
            Leaves::where(['empId' => $leaveRequest->empId, 'year' => $endYear])->update($updateFields);
        }

        $leaveRequest->status = 5;
        $leaveRequest->save();
        $this->mail($leaveRequest->empId, $request->id, EmailPattern::DELETE);

        return redirect()->route('leave-requests')->with('status', 'Leave cancelled successfully');
    }

    public function editLeaveRequest(Request $request)
    {
        $leaveRequest = LeaveRequest::find($request->id);

        if (!is_null($leaveRequest)) {
            return view('leaveApplication/leaveForm', ['leave' => $leaveRequest]);
        } else {
            return redirect()->route('leave-requests')->withErrors(['errorMessage' => 'Leave request does not exist']);
        }
    }

    public function updateLeave(ValidateLeaveApplication $request)
    {
        $empId = Auth::user()->id;
        $name = Auth::user()->name;
        $email = Auth::user()->email;

        $date1 = date_create($request->start_date);
        $date2 = date_create($request->end_date);
        $diff = date_diff($date1, $date2);
        $leaves = $diff->format("%a");

        $date = strtotime($request->start_date);

        if ((strcmp('Sunday', date("l", $date)) == 0 && $leaves <= 1) || (strcmp('Saturday', date("l", $date)) == 0 && $leaves <= 2)) {
            return back()->with('errorMessage', 'Sorry! You are trying to apply on holiday(s)');
        } else if ($leaves > 7) {
            return back()->with('errorMessage', 'Sorry! You are not allowed to apply for leaves more than a week');
        } else {
            if (strcmp('Saturday', date("l", strtotime($request->start_date))) == 0 && $leaves > 2) {
                $leaves -= 3;
            } else if (strcmp('Sunday', date("l", strtotime($request->start_date))) == 0 && $leaves > 1) {
                $leaves -= 2;
            }

            if (strcmp('Saturday', date("l", strtotime($request->end_date))) == 0) {
                $request->end_date = date('Y-m-d', strtotime("+2 days", strtotime($request->end_date)));
            } else if (strcmp('Sunday', date("l", strtotime($request->end_date))) == 0) {
                $leaves -= 1;
                $request->end_date = date('Y-m-d', strtotime("+1 days", strtotime($request->end_date)));
            } else if (strcmp('Monday', date("l", strtotime($request->end_date))) == 0) {
                $leaves -= 2;
            }
            $query = "UPDATE leave_requests set `leaveDate` = '$request->start_date' ,`return_date`= '$request->end_date' ,`leaves` = $leaves where id=$request->id";
            $result = DB::connection('mysql')->select(DB::raw($query));
            $this->mail($empId, $request->id, EmailPattern::UPDATE);
            return redirect()->route('leave-requests')->with('status', 'Your leave application has been updated');
        }
    }

    public function leaveRecord(Request $request)
    {
        $currentYear = Carbon::now()->year;
        $selectedYear = $request->year;
        if (!isset($selectedYear)) {
            $selectedYear = $currentYear;
        }

        $years = array();
        for ($year = $currentYear; $year >= 2021; $year--) {
            array_push($years, $year);
        }

        $leaves = NULL;
        if (Auth::user()->access_type == 1) {
            $leavesForYear = DB::table('leaves')->where('year', $selectedYear)->pluck('empId')->all();

            $usersNotInLeaves = User::select('id')
                ->whereNotIn('id', $leavesForYear)
                ->get();

            foreach ($usersNotInLeaves as $user) {
                Leaves::create(['empId' => $user->id, 'year' => $selectedYear]);
            }

            $whereStatement = "leaves.year=$selectedYear";
        } else {
            $userId = Auth::user()->id;
            $whereStatement = "leaves.year = $selectedYear and (users.tlId = $userId or users.id = $userId)";
        }

        $leaves = DB::table('users')
            ->leftJoin('leaves', 'users.id', '=', 'leaves.empId')
            ->select('leaves.*', 'users.name', 'users.tlId')
            ->whereRaw($whereStatement)
            ->get();
        return view('leaveApplication/leaves', ['leaves' => $leaves, 'selectedYear' => $selectedYear, 'years' => $years]);
    }

    public function downloadAttachment(Request $request)
    {
        $name = $request->filename;
        ob_end_clean();
        return Storage::download($name);
    }

    public function showEditLeavesRecordForm(Request $request)
    {
        if (Auth::user()->access_type != 1) {
            return back()->withErrors(['errorMessage' => 'You are not authorized to view that page.']);
        }

        if (!isset($request->year) || !isset($request->empId)) {
            return back()->withErrors(['errorMessage' => 'Insufficient record data.']);
        }

        $leaveRecord = Leaves::where(['empId' => $request->empId, 'year' => $request->year])->first();
        if (is_null($leaveRecord)) {
            return redirect()->route('leave-record')->withErrors(['errorMessage' => 'Leave record not found']);
        }
        $employeeName = $leaveRecord->employee->name;

        return view('leaveApplication/leaveRecordForm', ['leave' => $leaveRecord, 'employeeName' => $employeeName]);
    }

    public function updateLeavesRecord(Request $request)
    {
        if (Auth::user()->access_type != 1) {
            return back()->withErrors(['errorMessage' => 'You are not authorized to update leaves record.']);
        }

        Leaves::where(['empId' => $request->empId, 'year' => $request->year])
            ->update([
                'annualLeft' => $request->annualLeft,
                'sickLeft' => $request->sickLeft,
                'otherLeft' => $request->otherLeft,
            ]);

        return redirect()->route('leave-record')->with('status', 'Leave record has been updated');
    }

    public function getLeaveRequests()
    {
        $result = array();
        // Own leave requests
        $merged = DB::table(
            'leave_requests'
        )->join(
            'users',
            'leave_requests.empId',
            '=',
            'users.id'
        )->select(
            'leave_requests.*',
            'users.tlId'
        )->where(
            'empId',
            Auth::user()->id
        )
            // ->where('leave_requests.status','!=',5)
            ->whereYear('leaveDate', Carbon::now()->year)->get();

        $query = DB::table('leave_requests')
            ->join('users', 'leave_requests.empId', '=', 'users.id')
            ->select('leave_requests.*', 'users.tlId');

        if (Auth::user()->access_type == 1) {
            $query = $query->where(
                'leave_requests.empId',
                '!=',
                Auth::user()->id
            )
                // ->whereNotIn('leave_requests.status',  [2, 4, 5])
                ->whereYear('leaveDate', Carbon::now()->year);

            // if (Utils::isSuperAdmin()) {
            $result = $query->get();
            // } else {
            //     $branchId = Auth::user()->designation->department->branch->id;
            //     $departmentIds = Department::where("branch_id", $branchId)->pluck('id')->all();
            //     $designationIds = Designation::whereIn("deptId", $departmentIds)->pluck('id')->all();

            //     $result = $query->whereIn('users.designationId', $designationIds)->get();
            // }
        } else
         if (Auth::user()->access_type == 0 || Auth::user()->access_type == -1) {
            $result = $query->where([
                ['leave_requests.status', 0],
                ['users.tlId', Auth::user()->id]
            ])->get();
        }

        return $merged->merge($result)->all();
        // return $merged->all();
    }
}
