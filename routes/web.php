<?php

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

Route::get('/login', 'CustomAuthController@login')->middleware('readyLogin');
Route::post('/login/auth','CustomAuthController@loginUser')->name('loginUser');
Route::get('/','CustomAuthController@profile')->middleware('isLogin');
Route::get('logout','CustomAuthController@logoutUser')->name('logoutUser')->middleware('isLogin');

