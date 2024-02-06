<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your applicat[ion. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[CustomAuthController::class,'index']);

Route::get('/mssignin', [CustomAuthController::class, 'signin']);
Route::get('/mscallback', [CustomAuthController::class, 'callback']);

// Route::get('/mssignin',[AuthController::class,'signin']);
// Route::get('/mscallback',[AuthController::class,'callback']);
// Route::get('/mssigout',[AuthController::class,'signout']);
