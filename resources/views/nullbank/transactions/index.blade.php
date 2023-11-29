@php
    use App\Enums\TransactionOriginEnum;use App\Enums\TransactionTypeEnum;use App\NullBankModels\Agencia;use App\NullBankModels\Cliente;use App\NullBankModels\Conta;use App\NullBankModels\Endereco;use App\NullBankModels\Funcionario;use App\NullBankModels\Transacao;use Carbon\Carbon;
       if ($_SESSION['user_type'] == 'employee') {
           $employee = Funcionario::first($_SESSION['user_id']);
       }

       if ($_SESSION['user_type'] == 'customer') {
           $customer = Cliente::first($_SESSION['user_id']);
       }
@endphp
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
                            class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Transações</span>
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
                                <span class="text-gray-500">Total de Transações:</span>
                                <span class="dark:text-white">{{ request()->routeIs('customers.transactions.index') ? Transacao::allFromCustomer(customerCpf: $customer->cpf, search: '')->count() : Transacao::all()->count() }}</span>
                            </h5>
                        </div>
                    </div>
                    <div
                        class="flex flex-col md:flex-row items-stretch md:items-center md:space-x-3 space-y-3 md:space-y-0 justify-between mx-4 py-4 border-t dark:border-gray-700">
                        <div class="w-full md:w-1/2">
                            @if(request()->routeIs('customers.transactions.index'))
                                <form action=" {{ route('customers.transactions.index', $customer->cpf) }}" class="flex items-center">
                            @else
                                <form action=" {{ route('transactions.index') }}" class="flex items-center">
                            @endif
                            <form action=" {{ route('transactions.index') }}" class="flex items-center">
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
                                           placeholder="Pesquise por transações" required=""
                                           value="{{ request()->has('search') ? request()->input('search') : '' }}"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                </div>
                            </form>
                            @if(request()->has('search'))
                                @if(request()->routeIs('customers.transactions.index'))
                                    <a href=" {{ route('customers.transactions.index', $customer->cpf)  }}"
                                       class="mt-2 font-medium text-blue-600 dark:text-blue-500 hover:underline flex items-center"><i
                                            class="mr-1 text-xs fa-solid fa-x"></i> <span>limpar pesquisa</span>
                                    </a>
                                @else
                                    <a href=" {{ route('transactions.index')  }}"
                                       class="mt-2 font-medium text-blue-600 dark:text-blue-500 hover:underline flex items-center"><i
                                            class="mr-1 text-xs fa-solid fa-x"></i> <span>limpar pesquisa</span>
                                    </a>
                                @endif
                            @endif
                        </div>

                        <div
                            class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                            <button type="button" id="createButton" data-modal-target="createModal"
                                    data-modal-toggle="createModal"
                                    class="w-full px-2 py-2 md:w-auto flex items-center justify-center py-0 px-4 text-sm text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                <i class="fa-solid fa-plus mr-2"></i> Criar Transação
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-4">Número</th>
                                <th scope="col" class="p-4">Conta</th>
                                <th scope="col" class="p-4">Origem</th>
                                <th scope="col" class="p-4">Tipo</th>
                                <th scope="col" class="p-4">Valor</th>
                                <th scope="col" class="p-4">Feita em</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                @php
                                    $account = Conta::first($transaction->conta_id);
                                @endphp
                                <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">

                                    <td class="p-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <p>{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</p>
                                    </td>
                                    <td class="p-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <p>{{ str_pad($transaction->conta_id, 5, '0', STR_PAD_LEFT) }}</p>
                                    </td>
                                    <td class="p-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <p>{{ TransactionOriginEnum::toText($transaction->origem) }}</p>
                                    </td>
                                    <td class="p-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <p>{{ TransactionTypeEnum::toText($transaction->tipo) }}</p>
                                    </td>
                                    <td class="p-4 font-medium whitespace-nowrap dark:text-white {{$transaction->valor > 0 ? 'text-green-400' : 'text-red-400'}}">
                                        <p>R$ {{ number_format($transaction->valor, 2, ',', '.') }}</p>
                                    </td>
                                    <td class="p-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <p> {{ Carbon::make($transaction->created_at)->format('H:i:s - d/m/Y') }}</p>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $transactions }}
                </div>
            </div>
        </section>

        <!-- Create Modal -->
        <div id="createModal" tabindex="-1" aria-hidden="true"
             class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] md:h-full">
            <div class="relative p-4 w-full max-w-3xl h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                    <!-- Modal header -->
                    <div
                        class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Criar transferência</h3>
                        <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-toggle="createModal"
                                data-modal-target="createModal"
                        >
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    @if(request()->routeIs('customers.transactions.index'))
                        <form method="POST" action="{{ route('customers.transactions.store', $customer->cpf) }}">
                            @csrf
                            <div class="grid grid-cols-2 gap-5 justify-center">
                                <div class="mb-5">
                                    <label for="conta_id"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Conta</label>
                                    <input type="number" id="conta_id" name="conta_id"
                                           value="{{str_pad($account->id, 5, '0', STR_PAD_LEFT)}}"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           required readonly>
                                </div>
                                @else
                                    <form method="POST" action="{{ route('transactions.store') }}">
                                        @csrf
                                        <div class="grid grid-cols-2 gap-5 justify-center">
                                            <div class="mb-5">
                                                <label for="conta_id"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Conta</label>
                                                <select id="conta_id" name="conta_id"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        required>
                                                    <option value="" selected disabled>Selecione a conta</option>
                                                    @foreach($accounts as $account)
                                                        <option
                                                            value="{{$account->id}}">{{str_pad($account->id, 5, '0', STR_PAD_LEFT)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @endif
                                            <div class="mb-5">
                                                <label for="origem"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Origem
                                                    da Transferência</label>
                                                <select id="origem" name="origem"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        required>
                                                    <option value="" selected disabled>Selecione a origem da transação
                                                    </option>
                                                    @foreach(TransactionOriginEnum::toArray() as $key => $origin)
                                                        <option value="{{$key}}">{{$origin}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-5">
                                                <label for="tipo"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo
                                                    de Transferência</label>
                                                <select id="tipo" name="tipo"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        required>
                                                    <option value="" selected disabled>Selecione o tipo da transação
                                                    </option>
                                                    @foreach(TransactionTypeEnum::toArray() as $key => $type)
                                                        <option value="{{$key}}">{{$type}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-5">
                                                <label for="valor"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Valor</label>
                                                <input type="number" id="valor" name="valor"
                                                       placeholder="R$"
                                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                                            <button type="submit"
                                                    class="w-full px-2 py-2 md:w-auto flex items-center justify-center py-0 px-4 text-sm text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                                Criar
                                            </button>
                                        </div>
                                    </form>
                            </div>
                </div>
            </div>
        </div>

@endsection
