<?php

namespace App\Http\Controllers;

use App\Department;
use App\Designation;
use App\Branch;
use App\Http\Requests\validateDeleteUser;
use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;
use Illuminate\Support\Facades\Log;
use App\Helpers\Utils;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function updateUser(Request $request)
    {
        Log::info('[' . auth()->user()->username . '] update. Name:' . $request->name . ' Username:' . $request->username);
        $user = User::find($request->id);

        $userDepartmentId = Designation::find($user->designationId)->deptId;
        $userBranchId = Branch::find(Department::find($userDepartmentId)->branch_id)->id;

        $departments = Department::where('branch_id', $userBranchId)->get();
        $designations = Designation::where('deptId', $userDepartmentId)->get();
        $teamleads = DB::table('team_lead')->get();
        return view(
            'auth/updateUser',
            [
                'user' => $user,
                'userDepartmentId' => $userDepartmentId,
                'userBranchId' => $userBranchId,
                'departments' => $departments,
                'designations' => $designations,
                'teamLeads' => $teamleads
            ]
        );
    }

    public function update(Request $request)
    {
        Log::info('[' . auth()->user()->username . '] updateUser . Name:' . $request->name . ' Username:' . $request->username);
        $user = User::find($request->id);
        $user->designationId = $request->designation;
        $user->departmentId = $request->department;

        if ($user->access_type == -2 && $request->accessType <> -2) {
            DB::table('team_lead')->insert([
                'id' => $request->id,
                'name' => $user->name,
                'deptId' => $request->department
            ]);
        }
        $user->access_type = $request->accessType;

        $user->tlId = $request->teamLead;

        $user->email = $request->username;
        $user->username = $request->username;

        if ($user->save()) {
            return redirect()->route('users')->with('status', 'User updated successfully');
        }

        return redirect()->route('users')->withErrors(['errorMessage', 'Something went wrong. Could not update user.']);
    }

    /* Return User List */

    public function userList()
    {
        // $employeeBranchId = Auth::user()->designation->department->branch->id;
        // $employeeBranchDepartmentIds = Department::where("branch_id", $employeeBranchId)->pluck('id')->all();
        // $employeeBranchDesignationIds = Designation::whereIn("deptId", $employeeBranchDepartmentIds)->pluck('id')->all();

        // $users = Utils::isSuperAdmin() ? User::all()
        //     : User::whereIn("designationId", $employeeBranchDesignationIds)->get();
        return view('users/users')->with('userList', User::all());
    }

    public function deleteUser(validateDeleteUser $request)
    {
        Log::info("[" . auth()->user()->username . " trying to delete user " . $request->id);
        if (Auth::user()->access_type == 1) {

            User::destroy($request->id);

            $users = User::all();
            Log::info("[" . auth()->user()->username . " deleted user " . $request->id . " successfully");

            return back()->with('userList', $users)->with('status', 'User deleted successfully');
        } else {
            $users = array();
            return back()->with('userList', $users)->with('status', 'You are not authorized to delete users');
        }
    }
}
