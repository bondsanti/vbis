<?php

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


// Route Fallback
Route::fallback(function () {
    return redirect('/');
});

//Forget Password
Route::get('/forget',[CustomAuthController::class,'showForgetForm'])->name('forget.form');
Route::post('/forget',[CustomAuthController::class,'sendResetLinkEmail'])->name('forget.email');
Route::get('/forget/success',[CustomAuthController::class,'sendEmailSuccess']);
Route::get('/forget/reset/{token}',[CustomAuthController::class,'edit']);
Route::post('/forget/update',[CustomAuthController::class,'update'])->name('forget.update');
Route::get('/forget/complate',[CustomAuthController::class,'complate']);
Route::get('/token_exp',[CustomAuthController::class,'token_exp'])->name('token_exp');


Route::middleware(['alreadyLogin'])->group(function () {
    Route::get('/',[CustomAuthController::class,'index'])->name('login');
    Route::post('/auth',[CustomAuthController::class,'loginVbis'])->name('loginVbis');
    Route::get('/mssignin', [CustomAuthController::class, 'signin'])->name('mssignin');
    Route::get('/mscallback', [CustomAuthController::class, 'callback']);
});

//Frist Login
Route::middleware(['isAuth'])->group(function () {
    Route::get('/change-password',[CustomAuthController::class,'changePassword'])->name('change.password');
    Route::post('/change-password',[CustomAuthController::class,'updatePassword'])->name('update.password');
});


Route::middleware(['isLogin'])->group(function () {
    Route::get('/main',[CustomAuthController::class,'profileUser'])->name('main');
    Route::get('/logout/auth',[CustomAuthController::class,'logoutUser'])->name('logoutUser');

});

