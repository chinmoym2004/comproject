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

Auth::routes();

Route::middleware('auth')->group(function(){
    Route::get('/','\App\Http\Controllers\ChatAdminController@index');


    //\Auth::loginUsingId(1);

    Route::get('chat-admins','\App\Http\Controllers\ChatAdminController@index');
    Route::get('chat-rooms/{id}','\App\Http\Controllers\ChatAdminController@show');
    // Route::resource('chats', QbankController::class);
    // Route::resource('forums', QbankController::class);

    Route::get('/forum-admins','\App\Http\Controllers\ForumAdminController@index');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
