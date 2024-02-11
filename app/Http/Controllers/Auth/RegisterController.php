<?php

namespace App\Http\Controllers\Auth;

use App\Designation;
use App\User;
use App\TeamLead;
use App\Branch;
use App\Department;
use Auth;
use Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Http\Requests\registerValidationRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;
use DB;

class RegisterController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/users';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(registerValidationRequest $request)
    {
        if (Auth::user()->access_type == 1) {
            $query = "select * from user_pass";
            $prefixes = DB::connection('mysql')->select(DB::raw($query));
            $teamLeads = TeamLead::all();
            $branches = Branch::all();
            return view('auth.register', ['prefixes' => $prefixes, 'teamLeads' => $teamLeads, 'branches' => $branches]);
        } else {
            return back()->with('status', 'you are not allowed to create user');
        }
    }

    public function getDesignations(Request $request)
    {
        $query = "select * from designation where deptId=$request->id";
        $designations = DB::connection('mysql')->select(DB::raw($query));

        return $designations;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(registerValidationRequest $request)
    {
        Log::info('[' . auth()->user()->username . '] registerUser. Name:' . $request->name . ' Username:' . $request->username);

        $this->validator($request->all())->validate();

        Log::info('[' . auth()->user()->username . '] registerUser validated');
        $user = $this->create($request->all());

        event(new Registered($user));

        if ($request->accessType == 0 || $request->accessType == -1) {
            TeamLead::insert([
                'id' => $user->id,
                'name' => $user->name,
                'deptId' => $request->department
            ]);
        }
        //
        Log::info('[' . auth()->user()->username . '] registerUser successful');

        $status = $this->registered($request, $user) ?: redirect('users')->with('status', 'User created Successfully');
        return $status;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        Validator::extend('valid_username', function ($attr, $value) {
            return preg_match('/(.*)@(.+)\.(.+)/', $value);
        });
        //        Validator::extend('valid_username', function($attr, $value) {
        //            return preg_match('/^[A-Za-z0-9_]+$/', $value);
        //        });

        Validator::extend('valid_name', function ($attr, $value) {
            return preg_match('/^[a-zA-Z-. ]+$/', $value);
        });

        Validator::extend('valid_password', function ($attr, $value) {
            return preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@()$%^&*=_{}[\]:;\"'|\\<>,.\/~`±§+-]).{8,30}$/", $value);
        });


        return Validator::make(
            $data,
            [
                'name' => 'required|valid_name',
                'username' => 'required|max:50|unique:users|valid_username',
                'password' => 'required|string|valid_password|confirmed',
                'branch' => 'required',
                'department' => 'required',
                'designation' => 'required',
                'accessType' => 'required'
            ],
            [
                'valid_username' => 'please enter valid username e.g abc@gmail.com',
                'valid_name' => 'please enter valid Name.',
                'valid_password' => 'Password must be 8–30 characters, and include a number, a symbol, a lower and a upper case letter'
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'access_type' => $data['accessType'],
            'password' => bcrypt($data['password']),
            'is_change_pass' => 0,
            'prefix_id' => $data['prefix'],
            'email' => $data['username'],
            'designationId' => $data['designation'],
            'departmentId' => $data['department'],
            'tlId' => $data['teamLead']
        ]);
    }

    public function updatepassword(Request $request)
    {

        Log::info('[' . auth()->user()->username . '] updatepassword');

        Validator::extend('valid_password', function ($attr, $value) {
            return preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@()$%^&*=_{}[\]:;\"'|\\<>,.\/~`±§+-]).{8,30}$/", $value);
        });

        $this->validate(
            $request,
            [
                'oldpassword' => 'required',
                'newpassword' => 'required|valid_password',
                'confirmpassword' => 'required|same:newpassword',
            ],
            [
                'valid_password' => 'Password must be 8–30 characters, and include a number, a symbol, a lower and a upper case letter'
            ]
        );

        Log::info('[' . auth()->user()->username . '] updatepassword validated');

        $user = User::find(auth()->user()->id);


        if (!Hash::check($request->oldpassword, $user->password)) {
            Log::info('[' . auth()->user()->username . '] updatepassword fail');
            return back()->with('error', 'The specified password does not match the database password');
        } else {
            $user = User::findOrFail(Auth::user()->id);
            $user->password = bcrypt($request->newpassword);
            $user->save();
            Log::info('[' . auth()->user()->username . '] updatepassword successful');
            return back()->with('status', 'Password changed successfully');
        }
    }

    public function resetpassword(Request $request)
    {

        if ((Auth::user()->access_type == 1 || Auth::user()->access_type == 0) && ($request->id <> 1 && $request->id <> 0)) {
            Log::info('[' . auth()->user()->username . '] resetPassword request of ' . $request->id);
            $query = "SELECT * from users where id = " . $request->id;

            $user = DB::connection('mysql')->select(DB::raw($query));
            //            $user = User::where('id', $request->id)->first();
            //            print_r($user);
            //            die;
            $prefixId = "";
            foreach ($user as $us) {
                $prefixId = $us->prefix_id;
            }
            //            echo $prefixId;
            //            die;
            $queryUserPrefix = "Select * from user_pass where prefix_id = " . $prefixId;
            //            $userPrefix = UserPass::where('prefix_id', $prefixId)->get();
            $userPrefix = DB::connection('mysql')->select(DB::raw($queryUserPrefix));
            $userPass = "";
            foreach ($userPrefix as $prefix) {
                $userPass = $prefix->password;
            }

            $user = User::findOrFail($request->id);
            $user->password = bcrypt($userPass);
            $user->is_change_pass = 0;
            $user->save();
            Log::info('[' . auth()->user()->username . '] resetpassword successfully of user ' . $request->id);
            return back()->with('status', 'Password reset successfully');
        } else {
            Log::info('[' . auth()->user()->username . '] resetpassword unsuccessfully for user ' . $request->id);
            return back()->with('status', 'You are not authorized to reset admin password');
        }
    }
}
