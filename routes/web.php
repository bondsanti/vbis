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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', 'CustomAuthController@login')->middleware('readyLogin');
Route::post('/login/auth','CustomAuthController@loginUser')->name('loginUser');
Route::get('/','CustomAuthController@profile')->name('main')->middleware('isLogin');

Route::get('/forget','CustomAuthController@showForgetForm')->name('forget.form');
Route::post('/forget','CustomAuthController@sendResetLinkEmail')->name('forget.email');
Route::get('/forget/success','CustomAuthController@sendEmailSuccess');
Route::get('/forget/reset/{token}','CustomAuthController@edit');
Route::post('/forget/update','CustomAuthController@update')->name('forget.update');
Route::get('/forget/complate','CustomAuthController@complate');

//reset password
Route::get('/resetpassword','CustomAuthController@reset_pass')->name('reset_pass')->middleware('isLogin');
Route::post('/resetpassword/create','CustomAuthController@reset_create')->name('reset_create')->middleware('isLogin');

Route::get('logout','CustomAuthController@logoutUser')->name('logoutUser')->middleware('isLogin');

