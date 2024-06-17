<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;




// CheckToken to access Route
Route::middleware(['checkTokenApi'])->group(function () {

    // Login with Public App
    Route::get('/getAuth/{code}', [ApiController::class, 'getAuth'])->name('auth.getAuth');

    // HR Create New User
    Route::post('/create/users', [ApiController::class, 'createUserbyHR'])->name('user.create');

    // Allow Login InHouse App
    Route::get('/checktoken/{token}', [ApiController::class, 'checkTokenLogin'])->name('login.checkToken');

    // Allow Login Public App
    Route::get('/checktoken/publicsite/{token}', [ApiController::class, 'checkTokenPublicSite'])->name('login.checkTokenPublic');
});


