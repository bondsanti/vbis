<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;




// CheckToken to access Route
Route::middleware(['checkTokenApi'])->group(function () {

    // Login with Public App
    Route::get('/getAuth/{code}', [ApiController::class, 'getAuth'])->name('auth.getAuth');


    // HR To VBNext Routes
    Route::prefix('hr')->group(function () {
        Route::post('/create/users', [ApiController::class, 'createUserbyHR'])->name('user.create');
        Route::post('/resign/users', [ApiController::class, 'resignUserbyHR'])->name('user.resign');
        Route::post('/update/users', [ApiController::class, 'updateUserbyHR'])->name('user.update');
    });

    // Token Allow Login Routes
    Route::prefix('token')->group(function () {
          // Allow Login InHouse App
        Route::get('/check/{token}', [ApiController::class, 'checkTokenLogin'])->name('login.checkToken');
          // Allow Login Public App
        Route::get('/check/out/{token}', [ApiController::class, 'checkTokenOut'])->name('login.checkTokenOut');
    });

    // Logging public App
    Route::prefix('logs')->group(function () {
        //log login to report database
        Route::get('/login/{code},{system}', [ApiController::class, 'createLogLogin']);
    });


    Route::get('/get-role/users/{user_ids}',[ApiController::class,'getRoleUserAll']);
    // name_th user
    Route::get('/get-users/{user_ids}',[ApiController::class,'getNameUser']);
    // code for printer report
    Route::get('/get-users/code/{code}',[ApiController::class,'getNameUserByCode']);

    // api Report data
    Route::get('/get-admin/list',[ApiController::class,'getListAdmin']);
    Route::get('/get-users/list/{code},{old_code}',[ApiController::class,'getList']);
    Route::get('/get-users/listall/{code},{old_code}', [ApiController::class, 'getListAll']);
    Route::get('/get-project', [ApiController::class, 'getProject']);

    //to agent
    Route::post('/get-product',[ApiController::class, 'getProduct']);

});


