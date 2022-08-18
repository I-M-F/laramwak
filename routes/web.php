<?php

use Illuminate\Support\Facades\Route;

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

// Users Managment
Route::get('/all-user', [App\Http\Controllers\backend\UserController::class, 'AllUser'])->name('alluser');
Route::get('/add-user-index', [App\Http\Controllers\backend\UserController::class, 'AddUserIndex'])->name('adduserindex');
Route::post('/insert-user', [App\Http\Controllers\backend\UserController::class, 'InsertUser'])->name('insertuser');
Route::get('/edit-user/{id}', [App\Http\Controllers\backend\UserController::class, 'EditUser'])->name('edituser');
Route::post('/update-user/{id}', [App\Http\Controllers\backend\UserController::class, 'UpdateUser'])->name('updateuser');
Route::get('/delete-user/{id}', [App\Http\Controllers\backend\UserController::class, 'DeleteUser'])->name('deleteuser');

// Member Management
Route::view('/member-register','member-register')->name('member-register');

//Data Table
// Route::get('/datatables', function () {
//     return view('backend.datatables');
// });

