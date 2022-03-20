<?php

use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/ajax',[TeacherController::class,'index']);
Route::get('/teacher/all',[TeacherController::class,'allcat']);
Route::post('/teacher/store/',[TeacherController::class,'addData']);
Route::get('/teacher/edit/{id}',[TeacherController::class,'editData']);
Route::post('/teacher/update/{id}',[TeacherController::class,'updateData']);
