@php use App\Enums\AccountTypeEnum;use App\NullBankModels\Agencia;use App\NullBankModels\Cliente;use App\NullBankModels\Funcionario;use Carbon\Carbon; @endphp
@extends('layouts.home-app')

@section('content')
    <div>
        <h3 class="items-center justify-center text-3xl font-bold dark:text-white my-32 text-center">Selecione sua conta para acessar</h3>
        <section class="dark:bg-gray-900 grid grid-cols-2 gap-5 mx-64 justify-center min-h-screen">
        @foreach($accounts as $account)
            <a href="{{ route('customer.account-selected', $account->id) }}" class="hover:scale-105 transition-transform duration-300">
                @if( $_SESSION['user_type'] == 'customer')
                    @php
                        $customer = Cliente::first($_SESSION['user_id']);
                        $agencies = Agencia::all();
                        $managers = Funcionario::allManagers();
                    @endphp
                    <h3 class="text-3xl font-bold dark:text-white mb-5">Conta {{$account->id}}</h3>

                    <div class="grid grid-cols-2 gap-5 justify-center bg-gray-100 hover:bg-blue-100 p-4 rounded-[1.125rem]">

                        <div class="mb-5">
                            <label for="agencia"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Agência</label>
                            <input type="text" id="agencia" name="password"
                                   value="{{ str_pad($account->agencia_id, 5, '0', STR_PAD_LEFT) }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   disabled>
                        </div>

                        <div class="mb-5">
                            <label for="numero"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Conta</label>
                            <input type="text" id="numero" name="password"
                                   value="{{ str_pad($account->id, 5, '0', STR_PAD_LEFT) }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   disabled>
                        </div>

                        <div class="mb-5">
                            <label for="saldo"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Saldo</label>
                            <input type="text" id="saldo"
                                   value="{{ number_format($account->saldo, 2, ',', '.') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   disabled>
                        </div>

                        <div class="mb-5">
                            <label for="gerente"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gerente</label>
                            <input type="gerente" id="gerente"
                                   value="{{ Funcionario::first($account->gerente_id)->nome }} {{ Funcionario::first($account->gerente_id)->sobrenome }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   disabled>
                        </div>

                        <div class="mb-5">
                            <label for="tipo"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de
                                Conta</label>
                            <input type="tipo" id="tipo"
                                   value="{{ AccountTypeEnum::toText($account->tipo) }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   disabled>
                        </div>

                        @switch($account->tipo)
                            @case('CC')
                                <div class="mb-5">
                                    <label id="juros-label" for="juros" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Aniversário da conta</label>
                                    <input disabled value="{{ Carbon::make($account->aniversario)->format('d/m/Y') }}" type="text" id="juros" name="juros" step="0.01" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                                @break

                            @case('CP')
                                <div class="mb-5">
                                    <label id="juros-label" for="juros" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Juros</label>
                                    <input disabled type="number" id="juros" name="juros" step="0.01"
                                           value="{{ number_format($account->juros, 2, '.') }}"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    >
                                </div>
                                @break

                            @case('CE')
                                <div class="mb-5">
                                    <label id="limite_credito-label" for="limite_credito" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Limite de Crédito</label>
                                    <input
                                        disabled
                                        value="{{ number_format($account->limite_credito, 2, ',', '.') }}"
                                        type="number" id="limite_credito" name="limite_credito" step="0.01"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    >
                                </div>
                                @break
                        @endswitch
                    </div>
                @endif

            </a>
            @endforeach

        </section>
    </div>


@endsection
