<?php

use App\Http\Controllers\AgenciaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ContaController;
use App\Http\Controllers\DependenteController;
use App\Http\Controllers\EnderecosController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\TransacoesController;
use App\Http\Controllers\UsuarioController;
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

Route::view('/', 'nullbank.login')->name('home');

//Route::resource('/users', UsuarioController::class)->names('users');
//Route::post('/users/login', [ UsuarioController::class, 'login' ])->name('users.login');
//
//Route::get('/register', [ UsuarioController::class, 'register' ])->name('customers.register');

Route::resource('/agencies', AgenciaController::class)->names('agencies');
Route::resource('/employees', FuncionarioController::class)->names('employees');
Route::resource('/customers', ClienteController::class)->names('customers');
Route::resource('/accounts', ContaController::class)->names('accounts');
Route::resource('/dependants', DependenteController::class)->names('dependants');
Route::resource('/addresses', EnderecosController::class)->names('addresses');
Route::resource('/transactions', TransacoesController::class)->names('transactions');

//Route::middleware('guest')->group(function () {
//    Route::get('login', Login::class)
//        ->name('login');
//
//    Route::get('register', Register::class)
//        ->name('register');
//});
//
//Route::get('password/reset', Email::class)
//    ->name('password.request');
//
//Route::get('password/reset/{token}', Reset::class)
//    ->name('password.reset');
//
//Route::middleware('auth')->group(function () {
//    Route::get('email/verify', Verify::class)
//        ->middleware('throttle:6,1')
//        ->name('verification.notice');
//
//    Route::get('password/confirm', Confirm::class)
//        ->name('password.confirm');
//});
//
//Route::middleware('auth')->group(function () {
//    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
//        ->middleware('signed')
//        ->name('verification.verify');
//
//    Route::post('logout', LogoutController::class)
//        ->name('logout');
//});
