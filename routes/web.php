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
Route::group([
    'middleware' => [ 'auth', 'verify_email'],
], function(){

    Route::get('/', 'App\Http\Controllers\user\home@index')->name('home');

    Route::get('/profile' , 'App\Http\Controllers\user\profile@index')->name('profile');
    Route::get('/profile/{id}' , 'App\Http\Controllers\user\profile@go_to_s_profile');

    Route::post('/new_post' , 'App\Http\Controllers\user\post@new_post');
    Route::post('/post/comment' , 'App\Http\Controllers\user\post@new_comment');
    Route::post('/post/add_react' , 'App\Http\Controllers\user\post@add_react');
    Route::post('/post/remove_react' , 'App\Http\Controllers\user\post@remove_react');
    Route::post('/post/get_home_posts' , 'App\Http\Controllers\user\post@get_home_posts');

  
    Route::get('/search' , 'App\Http\Controllers\user\search@search');

    Route::post('friend/add_friend' , 'App\Http\Controllers\user\friend_requests@send_friend_request');
    Route::post('friend/accept_friend' , 'App\Http\Controllers\user\friend_requests@accpet_friend_request');
    Route::post('friend/cancel_request' , 'App\Http\Controllers\user\friend_requests@cancel_friend_request');
    Route::post('friend/reject_request' , 'App\Http\Controllers\user\friend_requests@reject_friend_request');

    Route::get('/chat' , 'App\Http\Controllers\user\chat@index');
    Route::post('/chat/send_msg' , 'App\Http\Controllers\user\chat@send_msg');
    Route::post('/chat/get_chat' , 'App\Http\Controllers\user\chat@get_chat');

    Route::post('/logout' , 'App\Http\Controllers\auth\logout@logout')->name('logout');

});


//auth

Route::get('/signup' , 'App\Http\Controllers\auth\signup@index')->name('signup');
Route::post('/signup' , 'App\Http\Controllers\auth\signup@signup');
Route::get('/register/verify_email/{token}' , 'App\Http\Controllers\auth\login@verify_email');

Route::get('/email_verifcation' , 'App\Http\Controllers\auth\email_verifcation@index');
Route::get('/register/verify_email/{token}' , 'App\Http\Controllers\auth\email_verifcation@verify_email');

Route::get('/login' , 'App\Http\Controllers\auth\login@index')->name('login');
Route::post('/login' , 'App\Http\Controllers\auth\login@login');

Route::get('/forget_password' , 'App\Http\Controllers\auth\forget_password@go_to_forget')->name('forget_password');
Route::post('/forget_password' , 'App\Http\Controllers\auth\forget_password@send_mail');

Route::get('/forget_password/{token}' , 'App\Http\Controllers\auth\forget_password@go_to_reset')->name('reset_password');
Route::post('/reset_password' , 'App\Http\Controllers\auth\forget_password@reset_password');

//login with google account
Route::get('/auth/redirect', 'App\Http\Controllers\google\google_auth@index')->name('login.google');
Route::get('/auth/callback', 'App\Http\Controllers\google\google_auth@login');




