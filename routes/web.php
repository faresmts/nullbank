<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\AgenciaController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Passwords\Confirm;
use App\Livewire\Auth\Passwords\Email;
use App\Livewire\Auth\Passwords\Reset;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Verify;
use App\NullBankModels\Cliente;
use App\NullBankModels\Conta;
use App\NullBankModels\Transacao;
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
    $data = [
        'cpf' => '05641459109',
        'usuario_id' => 1,
        'rg' => '123123',
        'rg_emitido_por' => 'SSP',
        'uf' => 'DG',
        'emails' => [
            0 => [
                'descricao' => 'Testezinho',
                'endereco' => 'fares@stargrid.pro'
            ],
            1 => [
                'descricao' => 'Testezinho2',
                'endereco' => 'fares2@stargrid.pro'
            ],
        ],
        'telefones' => [
            0 => [
                'descricao' => 'Testezinho',
                'numero' => '88993842429'
            ],
            1 => [
                'descricao' => 'Testezinho2',
                'numero' => '88993842422'
            ],
        ],
    ];

//    dd(Cliente::create($data));

    $a = Cliente::first('05641459109');
//    dd(Cliente::attach(4, 2, '05641459109'));

//    dd($a->update([]));

    dd($a->delete());

    return 'teste';
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)
        ->name('login');

    Route::get('register', Register::class)
        ->name('register');
});

Route::get('password/reset', Email::class)
    ->name('password.request');

Route::get('password/reset/{token}', Reset::class)
    ->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::get('email/verify', Verify::class)
        ->middleware('throttle:6,1')
        ->name('verification.notice');

    Route::get('password/confirm', Confirm::class)
        ->name('password.confirm');
});

Route::middleware('auth')->group(function () {
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('logout', LogoutController::class)
        ->name('logout');
});
