<?php

use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\MainController;
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
Route::get('_997744Isfnj)asdjknjZqwnmPOdfk_HHHGsfbp7AscaYjsn_asj20Ssdszf96GH645G1as41s_sdfnjozz/{id}&{token}',[CustomAuthController::class,'AllowLoginConnect']);
//login by agent system
//Route::get('/agent/{id}/{role_id}',[UserController::class,'createUserByAgentSystem']);


Route::middleware(['alreadyLogin'])->group(function () {
    Route::get('/',[CustomAuthController::class,'index']);
    Route::post('/auth',[CustomAuthController::class,'loginVbis'])->name('loginVbis');
    Route::get('/mssignin', [CustomAuthController::class, 'signin'])->name('mssignin');
    Route::get('/mscallback', [CustomAuthController::class, 'callback']);
});

//Frist Login
Route::middleware(['isAuth'])->group(function () {
    // Route::get('/change-password',[CustomAuthController::class,'changePassword'])->name('change.password');
    // Route::post('/change-password',[CustomAuthController::class,'updatePassword'])->name('update.password');
});

Route::get('/main',[MainController::class,'index']);
Route::middleware(['isLogin'])->group(function () {

    Route::get('/logout/auth',[CustomAuthController::class,'logoutUser'])->name('logoutUser');

});

