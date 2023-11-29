<?php

use App\Http\Controllers\AgenciaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ContaController;
use App\Http\Controllers\DependenteController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\TransacaoController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\NullbankAuth;
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

Route::view('/admin', 'nullbank.admin')->name('admin');
Route::post('/admin/login', [ LoginController::class, 'admin' ])->name('admin.login');
Route::view('/employee', 'nullbank.employee')->name('employee');
Route::post('/employee/login', [ LoginController::class, 'employee' ])->name('employee.login');
Route::view('/', 'nullbank.login')->name('customer');
Route::post('/login', [LoginController::class, 'login'])->name('customer.login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware([NullbankAuth::class])->group(function () {
    Route::resource('/agencies', AgenciaController::class)->names('agencies');
    Route::resource('/employees', FuncionarioController::class)->names('employees');
    Route::resource('/customers', ClienteController::class)->names('customers');
    Route::resource('/accounts', ContaController::class)->names('accounts');
    Route::resource('/dependants', DependenteController::class)->names('dependants');
    Route::resource('/addresses', EnderecoController::class)->names('addresses');
    Route::resource('/transactions', TransacaoController::class)->names('transactions');
    Route::view('/home', 'nullbank.home')->name('home');
    Route::view('/new-account', 'nullbank.new-account')->name('new-account');
    Route::get('/account-selected/{account}', [LoginController::class, 'accountSelected'])->name('customer.account-selected');
});


