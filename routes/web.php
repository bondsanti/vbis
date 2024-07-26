<?php

use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\DB;
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
// Route::fallback(function () {
//     return redirect('/');
// });
Route::get('/testmail', [UserController::class, 'testSendMail']);
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
    Route::get('/main/users',[UserController::class,'getUsers'])->name('users');
    Route::get('/main/users/disable',[UserController::class,'getUsersDisable'])->name('users.disable');
    Route::get('/main/users/print',[UserController::class,'print'])->name('users.print');
    Route::get('/checkin',[UserController::class,'checkIn'])->name('checkin');
    Route::post('/checkin',[UserController::class,'saveCheckIn'])->name('saveCheckIn');
    Route::post('/checkout',[UserController::class,'saveCheckOut'])->name('saveCheckOut');

    Route::post('/send-email', [UserController::class, 'sendEmail'])->name('send.email');

    Route::get('/powerapp/it/{user}', function ($user) {

        //dd($user);
        DB::table('vbeyond_report.log_login')->insert([
            'username' => $user,
            'dates' => date('Y-m-d'),
            'timeStm' => date('Y-m-d H:i:s'),
            'page' => 'IT-HelpDesk'
        ]);

        return redirect('https://apps.powerapps.com/play/e/default-5f1b572d-118b-45fc-b023-0f6d96cc9f24/a/630a28f9-4e1c-42b7-954a-bc162b9d59d3?tenantId=5f1b572d-118b-45fc-b023-0f6d96cc9f24&sourcetime=1717060477069');
    })->name('powerapp.it');

    Route::get('/powerapp/contract/{user}', function ($user) {

        //dd($user);
        DB::table('vbeyond_report.log_login')->insert([
            'username' => $user,
            'dates' => date('Y-m-d'),
            'timeStm' => date('Y-m-d H:i:s'),
            'page' => 'Legal-Contract'
        ]);

        return redirect('https://apps.powerapps.com/play/e/default-5f1b572d-118b-45fc-b023-0f6d96cc9f24/a/b64d3eb9-d850-4e16-b26c-f298465d1334?tenantId=5f1b572d-118b-45fc-b023-0f6d96cc9f24&hint=937f5830-c2b7-48c4-b0cf-737a593ca9de&sourcetime=1717150332749');
    })->name('powerapp.contract');


    Route::post('/update-active', [UserController::class, 'updateActive'])->name('update.active');
    Route::post('/update-role', [UserController::class, 'updateRole'])->name('update.role');

    Route::get('/logout/auth',[CustomAuthController::class,'logoutUser'])->name('logoutUser');
});

