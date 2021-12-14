<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
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
    Route::get('/register', [AuthController::class, 'register'])->name(WebRoute::AUTH_REGISTER);
    Route::post('/register', [AuthController::class, 'registerPost'])->name(WebRoute::AUTH_REGISTER_POST);
});

Route::middleware('auth')->group(function() {
    Route::get('/home', [HomeController::class, 'index'])->name(WebRoute::HOME_INDEX);

    Route::any('/code', [HomeController::class, 'codeIndex'])->name(WebRoute::CODE_INDEX);
    Route::any('/code/create', [HomeController::class, 'createCode'])->name(WebRoute::CODE_CREATE);
});

