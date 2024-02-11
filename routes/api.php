<?php

use App\Department;
use App\Designation;
use App\Http\Controllers\LeaveApplicationController;
use App\Leaves;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('branches/{id}/departments', function ($id) {
    return Department::where('branch_id', $id)->get();
});

Route::get('departments/{id}/designations', function ($id) {
    return Designation::where('deptId', $id)->get();
});

// Route::get('leaves/{id}', [LeaveApplicationController::class, 'getCurrentLeavesRecordById']);
Route::get('leaves/{id}', function ($id) {
    return
        Leaves::where([
            'empId' => $id,
            'year' => Carbon::now()->year
        ])->first();
});
