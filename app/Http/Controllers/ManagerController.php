<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateLeaveApplication;
use App\Mail\LeaveApplication;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use function auth;
use function env;
use function view;

class ManagerController extends Controller
{

    //level value 1 means approved by admin and value 2 means approve by HOD/TL
    private $level;
    private $comment;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $teamLeads = DB::table('department')
            ->rightJoin('team_lead', 'team_lead.deptId', '=', 'department.id')
            ->select('team_lead.*', 'department.name as department')
            ->get();
        $users = DB::table('users')->get();
        $departments = DB::table('department')->get();
        return view('leaveApplication/teamLeads')
            ->with('teamLeads', $teamLeads)
            ->with('users', $users)
            ->with('departments', $departments);
    }

    public function addManager(Request $request)
    {
        if (is_numeric($request->teamLead[1])) {
            $userId = substr($request->teamLead, 0, 2);
            $userName = substr($request->teamLead, 2);
        } else {
            $userId = substr($request->teamLead, 0, 1);
            $userName = substr($request->teamLead, 1);
        }
        $depId = $request->department;
        $tl = DB::table('team_lead')->where('id', '=', $userId)->get();
        if ($tl->count() > 0) {
            return back()->with('status', 'This user already exists in TL/HOD list');
        } else {
            DB::table('team_lead')->insert([
                'id' => $userId,
                'name' => $userName,
                'deptId' => $depId
            ]);
            return back()->with('status', 'Manager added successfully');
        }
    }

    public function updateManager(Request $request)
    {
        if (auth()->user()->access_type == 1) {
        }
        return back()->with('status', 'Manager updated successfully');
    }

    public function deleteManager(Request $request)
    {
        if (auth()->user()->access_type == 1) {
            DB::table('team_lead')->where('id', '=', $request->id)->delete();
        } else {
            return back()->with('status', 'You are not authorized');
        }
        return back()->with('status', 'Manager deleted successfully, please update all decendents of this user');
    }
}
