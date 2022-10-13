<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employees\EmployeeController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::middleware('auth')->group(function() {
	Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::middleware('employee')->prefix('employees')->group(function () {
        Route::resource('user', EmployeeController::class);  
    });
    Route::get('user/list', [EmployeeController::class, 'getList'])->name('user.list');
});
//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');