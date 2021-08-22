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

    
    Route::get('chat-room','\App\Http\Controllers\ChatAdminController@chatRoom');
    Route::get('chat-admins','\App\Http\Controllers\ChatAdminController@index');
    Route::get('chat-rooms/{id}','\App\Http\Controllers\ChatAdminController@show');
    // Route::resource('chats', QbankController::class);
    // Route::resource('forums', QbankController::class);

    Route::get('/forum-admins','\App\Http\Controllers\ForumAdminController@index');
    Route::get('/forums/{id}','\App\Http\Controllers\ForumAdminController@show');
    Route::get('/topics/{id}','\App\Http\Controllers\ForumAdminController@topics');

    Route::get('/inbox','\App\Http\Controllers\InboxController@index');

    Route::get('comments/pull-reference/{id}', 'App\Http\Controllers\CommentController@pullReferenceComment');
    Route::resource('/comments','App\Http\Controllers\CommentController');

    Route::get('circular-admin','\App\Http\Controllers\CircularController@index');
    Route::get('circulars/{id}','\App\Http\Controllers\CircularController@show');
    
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
