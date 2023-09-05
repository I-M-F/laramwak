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

Route::get('/add-all', [App\Http\Controllers\backend\UserController::class, 'addAllMembers'])->name('addAllMembers');
Route::post('/insert-all', [App\Http\Controllers\backend\UserController::class, 'insertAllMembers'])->name('insertAllMembers');

// Payments Managment
Route::get('/payment', [App\Http\Controllers\payment\MPESAController::class, 'payment'])->name('payment');
Route::get('/pendingPayList', [App\Http\Controllers\payment\MPESAController::class, 'pendingPay'])->name('pendingPay');
Route::get('/comPayList', [App\Http\Controllers\payment\MPESAController::class, 'commisionedPayList'])->name('pendingPay');
Route::get('/getAccessToken', [App\Http\Controllers\payment\MPESAController::class, 'getAccessToken'])->name('getAccessToken');
Route::get('/mpesaSTKPush/{phone}', [App\Http\Controllers\payment\MPESAController::class, 'mwakKCBMPESASTKPUSH'])->name('mwakKCBMPESASTKPUSH');
Route::get('/edit-tx/{phone}', [App\Http\Controllers\payment\MPESAController::class, 'editTx'])->name('editTx');
Route::get('/tuma-sms/{phone}', [App\Http\Controllers\payment\MPESAController::class, 'tumaSMS'])->name('tumaSMS');
Route::post('/update-tx/{phone}', [App\Http\Controllers\payment\MPESAController::class, 'updateTx'])->name('updateTx');
Route::post('/pay-notify/{id}', [App\Http\Controllers\payment\MPESAController::class, 'payNotify'])->name('payNotify');
Route::get('/pending-pay', [App\Http\Controllers\payment\MPESAController::class, 'pendingNotify'])->name('pendingNotify');

// Member Management
Route::view('/member-register','member-register')->name('member-register');
Route::get('/edit-user/{id}', [App\Http\Controllers\backend\UserController::class, 'EditUser'])->name('edituser');
Route::get('/all-members', [App\Http\Controllers\backend\UserController::class, 'AllMembers'])->name('allmembers');
Route::get('/sendSMS', [App\Http\Controllers\payment\MPESAController::class, 'sendSMS'])->name('sendSMS');
Route::get('/sendEmail', [App\Http\Controllers\payment\MPESAController::class, 'sendEmail'])->name('sendEmail');

Route::post('/all-bulk-sms', [App\Http\Controllers\FileController::class, 'allBulkSMS'])->name('allBulkSMS');
Route::get('/bulk-sms', [App\Http\Controllers\FileController::class, 'bulkSMS'])->name('bulkSMS');

Route::get('/add-docs', [App\Http\Controllers\FileController::class, 'addDocs'])->name('addDocs');
Route::post('/upload-docs', [App\Http\Controllers\FileController::class, 'uploadDocs'])->name('uploadDocs');
Route::get('/all-docs', [App\Http\Controllers\FileController::class, 'allDocs'])->name('allDocs');

Route::get('/view-docs/{id}', [App\Http\Controllers\FileController::class, 'viewDocs'])->name('viewDocs');

Route::get('calendar-event', [App\Http\Controllers\FullCalenderController::class, 'getEvents']);
Route::post('calendar-crud-ajax', [App\Http\Controllers\FullCalenderController::class, 'calendarEvents']);

// Route::get('/tweets/{kdfinfo}', [App\Http\Controllers\TwitterController::class, 'getUserTimeline'])->name('getUserTimeline');
// Route::get('/twitter', 'TwitterController@getIndex');

//Route::get('/import-data', [App\Http\Controllers\backend\UserController::class, 'importUsers'])->name('import-data');
// Route::post('/upload', [App\Http\Controllers\backend\UserController::class, 'uploadUsers'])->name('upload');
//Data Table
// Route::get('/datatables', function () {
//     return view('backend.datatables');
// });


