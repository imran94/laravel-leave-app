<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use App\User;
use Hash;
use Auth;
use Session;

class LoginController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/subscribers';
    protected $redirectTo = '/callReportHourly';

    protected function redirectTo()
    {
        return '/callReportHourly';
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function Login(Request $request)
    {

        Log::info('[IP:' . $request->getClientIP() . '] User ' . $request->username . ' attempt to login');

        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        Log::info('User ' . $request->username . ' validated');

        $isLocked = User::where(['username' => $request->username, 'is_lock' => 1])->first();
        if ($isLocked != null) {
            $currentDateTime = date("Y-m-d H:i:s");
            if ($isLocked->lock_expired > $currentDateTime) {
                //not yet expired
                Log::info('User ' . $request->username . ' account is locked');
                return redirect('login')
                    ->withInput($request->only('username', 'remember'))
                    ->withErrors([
                        'username' => 'Your account has been locked for 5 minutes',
                    ]);
            } else {
                //expired
                Log::info('User ' . $request->username . ' account is locked, but expired');
                $isLocked->is_lock = 0;
                $isLocked->wrong_pass_count = 0;
                $isLocked->save();
            }
        }

        $isFirstTime = User::where(['username' => $request->username, 'is_change_pass' => 0])->get();

        if ($isFirstTime->isEmpty()) {
            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials, $request->has('remember'))) {
                Log::info('User ' . $request->username . ' logged in to system');
                $user = User::where('username', $request->username)->first();
                $user->is_lock = 0;
                $user->wrong_pass_count = 0;
                $user->save();
                return redirect('login')
                    ->withInput($request->only('username', 'remember'))
                    ->withErrors([]);
            }

            Log::info('User ' . $request->username . ' invalid password');
            $user = User::where('username', $request->username)->first();
            if ($user != null) {
                return redirect('login')
                    ->withInput($request->only('username', 'remember'))
                    ->withErrors([
                        'username' => 'The credentials you provided do not match our records',
                    ]);
            } else {
                return redirect('login')
                    ->withInput($request->only('username', 'remember'))
                    ->withErrors([
                        'username' => 'The credentials you provided do not match our records',
                    ]);
            }
            //redirect again to login view with some errors line 3
        } else {

            Log::info('User ' . $request->username . ' is first time user');

            if (Hash::check($request->password, $isFirstTime[0]->password)) {
                Session::put('username', $isFirstTime[0]->username);
                return redirect('ChangePassword');
            } else {
                return redirect('login')
                    ->withInput($request->only('username', 'remember'))
                    ->withErrors([
                        'username' => 'credentials you provided do not match with our records',
                    ]);
            }
        }
    }

    public function logout(Request $request)
    {
        Log::info('[' . auth()->user()->username . '] logout');

        Auth::guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
