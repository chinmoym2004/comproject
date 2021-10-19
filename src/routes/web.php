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
    Route::get('/','\App\Http\Controllers\InboxController@index');
    Route::get('/home','\App\Http\Controllers\InboxController@index');


    //\Auth::loginUsingId(1);

    Route::get('downloads/{id}','\App\Http\Controllers\HomeController@downloadFile');
    
    Route::get('chat-room','\App\Http\Controllers\ChatController@index');
    Route::get('chat-admins','\App\Http\Controllers\ChatAdminController@index');
    Route::get('chat-rooms/{id}','\App\Http\Controllers\ChatAdminController@show');
    // Route::resource('chats', QbankController::class);
    // Route::resource('forums', QbankController::class);

    Route::resource('/forum-admins','\App\Http\Controllers\ForumAdminController');

    //Route::get('/forums/{slug}','\App\Http\Controllers\ForumController@getThreads');
    Route::resource('/forums','\App\Http\Controllers\ForumController');

    Route::get('/forums/{slug}/t/{slug2}','\App\Http\Controllers\ForumController@topics');

    Route::get('/topics/{id}','\App\Http\Controllers\ForumAdminController@topics');

    Route::get('/inbox','\App\Http\Controllers\InboxController@index');

    Route::get('comments/pull-reference/{id}', 'App\Http\Controllers\CommentController@pullReferenceComment');
    Route::resource('/comments','App\Http\Controllers\CommentController');

    Route::resource('circular-admin','\App\Http\Controllers\CircularController');

    Route::get('circulars','\App\Http\Controllers\CircularController@UserCircular');

    

    Route::get('/users','\App\Http\Controllers\UsersController@index');
    Route::get('/groups','\App\Http\Controllers\UsersController@groups');

    Route::get('/categories','\App\Http\Controllers\UsersController@categoryPanel');
    
});


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
