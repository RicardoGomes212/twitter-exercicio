<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

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


//default home route
Route::get('/home', [MessageController::class, 'index'])->name('home');

//route to change password
Route::get('/change-password', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('change-password');

//update password
Route::post('/change-password', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('update-password');

//update the twitter post on the database
Route::post('/saveMessageRoute', [App\Http\Controllers\MessageController::class, 'saveMessage'])->name('saveMessage');

//delete the twitter post on the database
Route::post('/deleteMessageRoute/{id}', [App\Http\Controllers\MessageController::class, 'deleteMessage'])->name('deleteMessage');

//move up a twitter post on the database
Route::post('/upMessageRoute/{id}', [App\Http\Controllers\MessageController::class, 'upMessage'])->name('upMessage');

//move down a twitter post on the database
Route::post('/downMessageRoute/{id}', [App\Http\Controllers\MessageController::class, 'downMessage'])->name('downMessage');

//notifications
Route::get('/notificationsRoute', [App\Http\Controllers\HomeController::class, 'notifications'])->name('notifications');