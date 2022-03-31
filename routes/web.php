<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TestController;
use App\WebRoute;
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

Route::get('/', function () {
    return view('auth.login');
});

// locale
Route::any('/locale/{locale}', function($locale) {
    App::setLocale($locale);
    session(['locale' => $locale]);

    return redirect()->back();
})->name(WebRoute::LOCALE_CHANGE);

// auth
Route::middleware('guest')->group(function() {
    Route::get('/login', [AuthController::class, 'login'])->name(WebRoute::AUTH_LOGIN);
    Route::post('/login', [AuthController::class, 'loginPost'])->name(WebRoute::AUTH_LOGIN_POST);
    // Route::get('/register', [AuthController::class, 'register'])->name(WebRoute::AUTH_REGISTER);
    // Route::post('/register', [AuthController::class, 'registerPost'])->name(WebRoute::AUTH_REGISTER_POST);
});

Route::middleware('auth')->group(function() {
    // auth
    Route::any('/logout', [AuthController::class, 'logout'])->name(WebRoute::AUTH_LOGOUT);

    // home
    Route::get('/home', [HomeController::class, 'index'])->name(WebRoute::HOME_INDEX);
    Route::get('/home/money', [HomeController::class, 'money_index'])->name(WebRoute::HOME_MONEY);

    // code
    Route::any('/code', [HomeController::class, 'codeIndex'])->name(WebRoute::CODE_INDEX);
    Route::any('/code/create', [HomeController::class, 'createCode'])->name(WebRoute::CODE_CREATE);
    Route::delete('/code/delete/{code}', [HomeController::class, 'deleteCode'])->name(WebRoute::CODE_DELETE);

    // transaction
    Route::prefix('transaction')->group(function() {
        Route::any('/{type}', [HomeController::class, 'transactionIndex'])->name(WebRoute::TRANSACTION_INDEX);
    });

    // team management
    Route::prefix('team')->group(function() {
        Route::any('/home', [TeamController::class, 'home'])->name(WebRoute::TEAM_HOME);
        Route::any('/', [TeamController::class, 'index'])->name(WebRoute::TEAM_INDEX);
        Route::any('/net/{user?}', [TeamController::class, 'netIndex'])->name(WebRoute::TEAM_NET);
    });

    // center
    Route::prefix('center')->group(function() {
        Route::any('/', [CenterController::class, 'index'])->name(WebRoute::CENTER_INDEX);
        Route::get('/register', [CenterController::class, 'register'])->name(WebRoute::CENTER_REGISTER);
        Route::post('/register', [CenterController::class, 'registerPost'])->name(WebRoute::CENTER_REGISTER_POST);
    });

    // fund
    Route::prefix('fund')->group(function() {
        Route::any('/home', [FundController::class, 'home'])->name(WebRoute::FUND_HOME);
        Route::get('/conversion', [FundController::class, 'conversionIndex'])->name(WebRoute::FUND_CONVERSION_INDEX);
        Route::post('/conversion', [FundController::class, 'conversionPost'])->name(WebRoute::FUND_CONVERSION_POST);
        Route::get('/transfer', [FundController::class, 'transferIndex'])->name(WebRoute::FUND_TRANSFER_INDEX);
        Route::post('/transfer', [FundController::class, 'transferPost'])->name(WebRoute::FUND_TRANSFER_POST);
        Route::get('/withdraw', [FundController::class, 'withdraw'])->name(WebRoute::FUND_WITHDRAW_INDEX);
        Route::any('/conversion/request', [FundController::class, 'conversionApprovalRequest'])->name(WebRoute::FUND_TRANSFER_APPROVAL_REQUEST);
        Route::get('/conversion/request/all', [FundController::class, 'conversionRequestIndex'])->name(WebRoute::FUND_TRANSFER_REQUEST_INDEX);
        Route::any('/conversion/request/approve/{user}', [FundController::class, 'conversionRequestApprove'])->name(WebRoute::FUND_TRANSFER_REQUEST_APPROVE);
        Route::get('/company/edit', [FundController::class, 'companyEdit'])->name(WebRoute::FUND_COMPANY_EDIT);
        Route::post('/company/edit', [FundController::class, 'companyEditPost'])->name(WebRoute::FUND_COMPANY_EDIT_POST);
        Route::get('/company/adjust', [FundController::class, 'companyAdjust'])->name(WebRoute::FUND_COMPANY_ADJUST);
        Route::post('/company/adjust', [FundController::class, 'companyAdjustPost'])->name(WebRoute::FUND_COMPANY_ADJUST_POST);
        Route::get('/company/transfer', [FundController::class, 'companyTranfer'])->name(WebRoute::FUND_COMPANY_TRANSFER);
        Route::post('/company/transfer', [FundController::class, 'companyTranferPost'])->name(WebRoute::FUND_COMPANY_TRANSFER_POST);
    });

    // profile
    Route::prefix('auth')->group(function() {
        Route::any('/home', [AuthController::class, 'home'])->name(WebRoute::AUTH_HOME);
        Route::get('/profile', [AuthController::class, 'profile'])->name(WebRoute::AUTH_PROFILE);
        Route::post('/profile', [AuthController::class, 'profilePost'])->name(WebRoute::AUTH_PROFILE_POST);
        Route::get('/bank', [AuthController::class, 'bank'])->name(WebRoute::AUTH_BANK);
        Route::post('/bank', [AuthController::class, 'bankPost'])->name(WebRoute::AUTH_BANK_POST);
        Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name(WebRoute::AUTH_RESET_PASSWORD);
        Route::post('/reset-password', [AuthController::class, 'resetPasswordPost'])->name(WebRoute::AUTH_RESET_PASSWORD_POST);
        Route::any('/phone', [AuthController::class, 'phone'])->name(WebRoute::AUTH_PHONE);
    });

    // admin
    Route::prefix('admin')->group(function() {
        Route::get('/user', [AdminController::class, 'userIndex'])->name(WebRoute::ADMIN_USER_INDEX);
        Route::post('/user', [AdminController::class, 'userCreate'])->name(WebRoute::ADMIN_USER_CREATE);

        Route::post('/user/activate_in_net', [AdminController::class, 'userActivateInSpecNet'])->name(WebRoute::ADMIN_USER_ACTIVATE_IN_SPEC_NET);
        Route::post('/user/activate', [AdminController::class, 'userActivate'])->name(WebRoute::ADMIN_USER_ACTIVATE);
        Route::any('/user/{user}/inactivate', [AdminController::class, 'userInactivate'])->name(WebRoute::ADMIN_USER_INACTIVATE);
        Route::delete('/user/{user}/delete', [AdminController::class, 'userDelete'])->name(WebRoute::ADMIN_USER_DELETE);
        Route::get('/user/validate-name', [AdminController::class, 'validateName'])->name(WebRoute::ADMIN_USER_VALIDATE_NAME);

        Route::get('/company', [AdminController::class, 'companyIndex'])->name(WebRoute::ADMIN_COMPANY_INDEX);
        Route::post('/company', [AdminController::class, 'companyPost'])->name(WebRoute::ADMIN_COMPANY_PROMOTE);
    });
});


// This is just for test route
Route::any('/test/registration/{user}', [TestController::class, 'testPerformRegistration']);

