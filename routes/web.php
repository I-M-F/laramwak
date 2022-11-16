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

Auth::routes(['verify'=> true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Users Managment
Route::get('/all-user', [App\Http\Controllers\backend\UserController::class, 'AllUser'])->name('alluser');

Route::get('/add-user-index', [App\Http\Controllers\backend\UserController::class, 'AddUserIndex'])->name('adduserindex');
Route::post('/insert-user', [App\Http\Controllers\backend\UserController::class, 'InsertUser'])->name('insertuser');
Route::get('/edit-user/{id}', [App\Http\Controllers\backend\UserController::class, 'EditUser'])->name('edituser');
Route::get('/view-member/{id}', [App\Http\Controllers\backend\UserController::class, 'viewMember'])->name('viewmember');
Route::post('/update-user/{id}', [App\Http\Controllers\backend\UserController::class, 'UpdateUser'])->name('updateuser');
Route::post('/update-member/{id}', [App\Http\Controllers\backend\UserController::class, 'updateMember'])->name('updateMember');
Route::post('/update-member-dets/{id}', [App\Http\Controllers\backend\UserController::class, 'updateMemberDets'])->name('updateMemberDets');
Route::post('/approve-member/{id}', [App\Http\Controllers\backend\UserController::class, 'approveMember'])->name('approveMember');

Route::get('/delete-user/{email}', [App\Http\Controllers\backend\UserController::class, 'DeleteUser'])->name('deleteuser');


// Payments Managment
Route::get('/payment', [App\Http\Controllers\payment\MPESAController::class, 'payment'])->name('payment');
Route::get('/getAccessToken', [App\Http\Controllers\payment\MPESAController::class, 'getAccessToken'])->name('getAccessToken');
Route::get('/mpesaSTKPush/{phone}', [App\Http\Controllers\payment\MPESAController::class, 'mwakSTKPush'])->name('mwakSTKPush');
Route::get('/edit-tx/{phone}', [App\Http\Controllers\payment\MPESAController::class, 'editTx'])->name('editTx');
Route::get('/tuma-sms/{phone}', [App\Http\Controllers\payment\MPESAController::class, 'tumaSMS'])->name('tumaSMS');
Route::post('/update-tx/{phone}', [App\Http\Controllers\payment\MPESAController::class, 'updateTx'])->name('updateTx');
Route::post('/pay-notify/{id}', [App\Http\Controllers\payment\MPESAController::class, 'payNotify'])->name('payNotify');
// Member Management
Route::view('/member-register','member-register')->name('member-register');
Route::get('/edit-user/{id}', [App\Http\Controllers\backend\UserController::class, 'EditUser'])->name('edituser');
Route::get('/all-members', [App\Http\Controllers\backend\UserController::class, 'AllMembers'])->name('allmembers');
Route::get('/sendSMS', [App\Http\Controllers\payment\MPESAController::class, 'sendSMS'])->name('sendSMS');
Route::get('/sendEmail', [App\Http\Controllers\payment\MPESAController::class, 'sendEmail'])->name('sendEmail');

Route::get('/add-docs', [App\Http\Controllers\FileController::class, 'addDocs'])->name('addDocs');
Route::post('/upload-docs', [App\Http\Controllers\FileController::class, 'uploadDocs'])->name('uploadDocs');
Route::get('/all-docs', [App\Http\Controllers\FileController::class, 'allDocs'])->name('allDocs');

Route::get('/view-docs/{id}', [App\Http\Controllers\FileController::class, 'viewDocs'])->name('viewDocs');

//Route::get('/import-data', [App\Http\Controllers\backend\UserController::class, 'importUsers'])->name('import-data');
// Route::post('/upload', [App\Http\Controllers\backend\UserController::class, 'uploadUsers'])->name('upload');
//Data Table
// Route::get('/datatables', function () {
//     return view('backend.datatables');
// });

