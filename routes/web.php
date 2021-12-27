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

Route::get('/', [\App\Http\Controllers\ChatsController::class, 'index'])->name('index');
Route::get('messages', [\App\Http\Controllers\ChatsController::class, 'fetchMessages'])->name('fetchMessages');
Route::post('messages', [\App\Http\Controllers\ChatsController::class, 'sendMessage'])->name('sendMessage');
Route::post('delete/message', [\App\Http\Controllers\ChatsController::class, 'deleteMessage'])->name('deleteMessage');
Route::post('update/read', [\App\Http\Controllers\ChatsController::class, 'updateRead'])->name('updateRead');
Route::post('upload/image', [\App\Http\Controllers\ChatsController::class, 'uploadImage'])->name('uploadImage');
Route::post('message/user', [\App\Http\Controllers\ChatsController::class, 'getLastMessageByUser'])->name('getLastMessageByUser');
Route::post('create/log', [\App\Http\Controllers\ChatsController::class, 'createLog'])->name('createLog');
