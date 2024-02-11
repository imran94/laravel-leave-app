<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\User;
use Auth;
use Session;


class resetPassword extends Controller
{
   public function resetPassword(Request $request)
    {

        /* $validate=$request->validate([
        'password' => 'required|string|min:16|confirmed'
         ]);
*/
         Log::info('['.Session::get('username').'] resetPassword first time user');

         Validator::extend('valid_password', function($attr, $value){
            return preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@()$%^&*=_{}[\]:;\"'|\\<>,.\/~`±§+-]).{8,30}$/", $value);
        }); 

         $validate=$request->validate([
            'password'     => 'required|valid_password',
            'password_confirmation' => 'required|same:password',
        ],
        [
            'valid_password' => 'Password must be 8–30 characters, and include a number, a symbol, a lower and a upper case letter'
        ]);
     
      Log::info('['.Session::get('username').'] resetPassword validated');

      $user=User::where('username', Session::get('username'))->firstOrFail();
      //dd($user);
      $user->password=bcrypt($request->password);
      $user->is_change_pass=1;
      $user->save();
      $request->merge(['username'=>$user->username]);
      $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials, $request->has('remember')))
        { 
            Log::info('['.$user->username.'] resetPassword successful');
            
            return auth()->user()->access_type !== 1 ? redirect('/applyForLeave') : redirect('/users');
            
        } else {
            Log::info('['.$user->username.'] resetPassword fail');
            return redirect('/login');
        }
    }
}
