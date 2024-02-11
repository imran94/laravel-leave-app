<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaveApplicationController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\resetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('login', [LoginController::class, 'showLoginForm'])->name('login');

// First Time Password Reset
Route::get('ChangePassword', function (Request $request) {
    return view('auth.changePassword');
});
Route::post('changePasswordRequest', [resetPassword::class, 'resetPassword']);

Route::view('forgot-password', 'auth.passwords.email');
Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('email-reset-link');

Route::get('reset/password/{token}', [ResetPasswordController::class, 'passwordResetForm'])->middleware('guest')->name('password.reset');
Route::get('register-new-user', [ResetPasswordController::class, 'showRegistrationForm']);

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => ['isAdmin']], function () {
        Route::get('users', [HomeController::class, 'userList'])->name('users');
        Route::get('update-user', [HomeController::class, 'updateUser']);
        Route::put('update-user', [HomeController::class, 'update']);
        Route::get('deleteUser', [HomeController::class, 'deleteUser']);

        Route::get('getDesignations', [RegisterController::class, 'getDesignations']);
        Route::get('resetpasswordRequest', [RegisterController::class, 'resetpassword']);
    });

    Route::get('updatepassword', function () {
        return view('users.Updatepassword');
    });

    Route::post('updatepasswordRequest', [RegisterController::class, 'updatepassword']);

    Route::get('applyForLeave', [LeaveApplicationController::class, 'index']);
    Route::post('storeLeaveRequest', [LeaveApplicationController::class, 'store']);
    Route::get('leave-requests', [LeaveApplicationController::class, 'leaveRequests'])->name('leave-requests');
    Route::get('leave-history', [LeaveApplicationController::class, 'leaveRequestsHistory']);
    Route::get('approve-request', [LeaveApplicationController::class, 'approveRequest']);
    Route::put('approve', [LeaveApplicationController::class, 'approve']);
    Route::get('disapprove-request', [LeaveApplicationController::class, 'disapproveRequest']);
    Route::put('disapprove', [LeaveApplicationController::class, 'disapprove']);
    Route::get('delete-leave-request', [LeaveApplicationController::class, 'deleteLeaveRequest']);
    Route::get('edit-leave-request', [LeaveApplicationController::class, 'editLeaveRequest']);
    Route::post('update-leave-request', [LeaveApplicationController::class, 'updateLeave']);
    Route::get('/leave-record', [LeaveApplicationController::class, 'leaveRecord'])->name('leave-record');
    Route::get('download-file', [LeaveApplicationController::class, 'downloadAttachment']);
    Route::get('/edit-leaves-record', [LeaveApplicationController::class, 'showEditLeavesRecordForm'])
        ->name('showEditLeavesRecordForm');
    Route::put('update-leaves-record', [LeaveApplicationController::class, 'updateLeavesRecord'])
        ->name('update-leaves-record');

    Route::get('managers', [ManagerController::class, 'index']);
    Route::post('addManager', [ManagerController::class, 'addManager']);
    Route::get('update-manager', [ManagerController::class, 'updateManager']);
    Route::get('remove-manager', [ManagerController::class, 'deleteManager']);
});  //Auth End

Route::get('/', function (Request $request) {
    if (Auth::check()) {
        return redirect()->route('leave-requests');
    }
    return redirect()->route('login');
});

Auth::routes();
