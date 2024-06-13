<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/users/year/{year}',[UserController::class,'getUserSignInByYear'])->middleware('checkTokenApi')->name('api.usersSignInByYear');

Route::post('/role-stock/{code}', [ApiController::class, 'getRoleStock'])->middleware('checkTokenApi');
Route::post('/create/users', [ApiController::class, 'createUserbyHR'])->middleware('checkTokenApi');
Route::get('/checktoken/{token}', [ApiController::class, 'checkTokenLogin'])->middleware('checkTokenApi');


