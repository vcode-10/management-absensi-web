<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');

Route::get('/attendances', [App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
Route::post('/attendances', [App\Http\Controllers\AttendanceController::class, 'getAttendanceAndDeparture'])->name('attendance.absen');
Route::post('/attendances/sick', [App\Http\Controllers\AttendanceController::class, 'submitSick'])->name('attendance.sick');
Route::post('/attendances/approval', [App\Http\Controllers\AttendanceController::class, 'submitApproval'])->name('attendance.approval');
Route::get('/attendances/rekap-bulanan', [App\Http\Controllers\AttendanceController::class, 'indexRekap'])->name('total_data');

Route::resource('users', \App\Http\Controllers\UserController::class)
    ->middleware('auth');
Route::resource('teachers', \App\Http\Controllers\TeacherControlller::class)
    ->middleware('auth');
Route::resource('shifts', \App\Http\Controllers\ShiftController::class)
    ->middleware('auth');
Route::resource('roles', \App\Http\Controllers\RoleController::class)
    ->middleware('auth');