@php use App\Enums\AccountTypeEnum;use App\NullBankModels\Agencia;use App\NullBankModels\Conta;use App\NullBankModels\Funcionario;use App\NullBankModels\Usuario;use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
    <div class="ml-64">
        <nav class="flex mt-4 mx-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href=" {{ route('home') }} "
                       class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        Home
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 9 4-4-4-4"/>
                        </svg>
                        <span
                            class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Contas</span>
                    </div>
                </li>
            </ol>
        </nav>

        <section class="mt-5 dark:bg-gray-900 p-3 sm:p-5 antialiased">
            <div class="mx-auto max-w-screen-2xl px-4 lg:px-12">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div
                        class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                        <div class="flex-1 flex items-center space-x-2">
                            <h5>
                                <span class="text-gray-500">Total de Contas:</span>
                                <span class="dark:text-white">{{ Conta::allFromAgency($agency->id)->count() }}</span>
                            </h5>
                        </div>
                    </div>
                    <div
                        class="flex flex-col md:flex-row items-stretch md:items-center md:space-x-3 space-y-3 md:space-y-0 justify-between mx-4 py-4 border-t dark:border-gray-700">
                        <div class="w-full md:w-1/2">
                            <form action=" {{ route('employees.accounts.index', $employee->id) }}" class="flex items-center">
                                <label for="simple-search" class="sr-only">Search</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                             fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="search" id="simple-search"
                                           placeholder="Pesquise por contas" required=""
                                           value="{{ request()->has('search') ? request()->input('search') : '' }}"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                </div>
                            </form>
                            @if(request()->has('search'))
                                <a href=" {{ route('employees.accounts.index', $employee->id)  }}"
                                   class="mt-2 font-medium text-blue-600 dark:text-blue-500 hover:underline flex items-center"><i
                                        class="mr-1 text-xs fa-solid fa-x"></i> <span>limpar pesquisa</span></a>
                            @endif
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-4">Número</th>
                                <th scope="col" class="p-4">Cliente 1</th>
                                <th scope="col" class="p-4">Cliente 2</th>
                                <th scope="col" class="p-4">Gerente</th>
                                <th scope="col" class="p-4">Saldo</th>
                                <th scope="col" class="p-4 text-center">Tipo</th>
                                <th scope="col" class="p-4 text-center">Atributo Especial</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($accounts as $account)
                                @php
                                    $managerAccount = Funcionario::first($account->gerente_id);
                                    $managerUser = Usuario::first($managerAccount->usuario_id);
                                    $clientes = $account->getClientes();
                                @endphp

                                <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="p-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <p>{{ str_pad($account->id, 5, '0', STR_PAD_LEFT) }}</p>
                                    </td>
                                    <td class="p-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <p>{{ str_pad($account->agencia_id, 5, '0', STR_PAD_LEFT) }}</p>
                                    </td>
                                    <td class="p-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <p> {{ $clientes->count() > 0 ? $clientes->first()->nome . ' ' . $clientes->first()->sobrenome : '----' }}</p>
                                    </td>
                                    <td class="p-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <p> {{ $clientes->count() == 2 ? $clientes->last()->nome . ' ' . $clientes->last()->sobrenome : '----' }}</p>
                                    </td>
                                    <td class="p-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <p> {{ $managerUser->nome }} {{ $managerUser->sobrenome }}</p>
                                    </td>
                                    <td class="p-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                        <p>R$ {{ number_format($account->saldo, 2, ',', '.') }}</p>
                                    </td>
                                    <td class="p-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                        <p>{{ AccountTypeEnum::toText($account->tipo) }}</p>
                                    </td>
                                    @switch($account->tipo)
                                        @case('CC')
                                            <td class="p-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                                <p>{{ Carbon::make($account->aniversario)->format('d/m/Y') }}</p>
                                            </td>
                                            @break

                                        @case('CP')
                                            <td class="p-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                                <p>%{{ number_format($account->juros, 2, '.') }}</p>
                                            </td>
                                            @break

                                        @case('CE')
                                            <td class="p-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                                <p>R$ {{ number_format($account->limite_credito, 2, ',', '.') }}</p>
                                            </td>
                                            @break
                                    @endswitch
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $accounts }}
                </div>
            </div>
        </section>
@endsection
