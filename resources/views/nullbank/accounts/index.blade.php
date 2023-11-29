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
                                <span class="dark:text-white">{{ Conta::all()->count() }}</span>
                            </h5>
                        </div>
                    </div>
                    <div
                        class="flex flex-col md:flex-row items-stretch md:items-center md:space-x-3 space-y-3 md:space-y-0 justify-between mx-4 py-4 border-t dark:border-gray-700">
                        <div class="w-full md:w-1/2">
                            <form action=" {{ route('accounts.index') }}" class="flex items-center">
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
                                <a href=" {{ route('accounts.index')  }}"
                                   class="mt-2 font-medium text-blue-600 dark:text-blue-500 hover:underline flex items-center"><i
                                        class="mr-1 text-xs fa-solid fa-x"></i> <span>limpar pesquisa</span></a>
                            @endif
                        </div>

                        <div
                            class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                            <button type="button" id="createButton" data-modal-target="createModal"
                                    data-modal-toggle="createModal"
                                    class="w-full px-2 py-2 md:w-auto flex items-center justify-center py-0 px-4 text-sm text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                <i class="fa-solid fa-plus mr-2"></i> Inserir Conta
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-4">Número</th>
                                <th scope="col" class="p-4">Nome da Agência</th>
                                <th scope="col" class="p-4">Cliente 1</th>
                                <th scope="col" class="p-4">Cliente 2</th>
                                <th scope="col" class="p-4">Gerente</th>
                                <th scope="col" class="p-4">Saldo</th>
                                <th scope="col" class="p-4 text-center">Tipo</th>
                                <th scope="col" class="p-4 text-center">Atributo Especial</th>
                                <th scope="col" class="p-4">Ações</th>
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
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <p>{{ str_pad($account->id, 5, '0', STR_PAD_LEFT) }}</p>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <p>{{ str_pad($account->agencia_id, 5, '0', STR_PAD_LEFT) }}</p>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <p> {{ $clientes->count() > 0 ? $clientes->first()->nome . ' ' . $clientes->first()->sobrenome : '----' }}</p>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <p> {{ $clientes->count() == 2 ? $clientes->last()->nome . ' ' . $clientes->last()->sobrenome : '----' }}</p>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <p> {{ $managerUser->nome }} {{ $managerUser->sobrenome }}</p>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                        <p>R$ {{ number_format($account->saldo, 2, ',', '.') }}</p>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                        <p>{{ AccountTypeEnum::toText($account->tipo) }}</p>
                                    </td>
                                    @switch($account->tipo)
                                        @case('CC')
                                            <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                                <p>{{ Carbon::make($account->aniversario)->format('d/m/Y') }}</p>
                                            </td>
                                            @break

                                        @case('CP')
                                            <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                                <p>%{{ number_format($account->juros, 2, '.') }}</p>
                                            </td>
                                            @break

                                        @case('CE')
                                            <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                                <p>R$ {{ number_format($account->limite_credito, 2, ',', '.') }}</p>
                                            </td>
                                            @break
                                    @endswitch


                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center space-x-4">
                                            <a href=" {{ route('accounts.edit', $account->id) }}"
                                               class="flex items-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-600 dark:focus:ring-blue-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 -ml-0.5"
                                                     viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/>
                                                    <path fill-rule="evenodd"
                                                          d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                                Editar
                                            </a>

                                            <button type="button" data-modal-target="delete-modal-{{ $account->id }}"
                                                    data-modal-toggle="delete-modal-{{ $account->id }}"
                                                    class="flex items-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 -ml-0.5"
                                                     viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                          d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                                Deletar
                                            </button>
                                        </div>



                                        <!-- Delete Modal -->
                                        <div id="delete-modal-{{ $account->id }}" tabindex="-1"
                                             class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            <div class="relative w-full h-auto max-w-md max-h-full">
                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                    <button type="button"
                                                            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                                            data-modal-toggle="delete-modal-{{ $account->id }}">
                                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                                             viewbox="0 0 20 20"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                  clip-rule="evenodd"/>
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                    <div class="p-6 text-center">
                                                        <svg aria-hidden="true"
                                                             class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200"
                                                             fill="none" stroke="currentColor" viewbox="0 0 24 24"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                            Você tem certeza que quer
                                                            excluir essa conta?</h3>
                                                        <div class="flex items-center gap-3 justify-center">
                                                            <form method="POST"
                                                                  action="{{ route('accounts.destroy', $account->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button
                                                                    data-modal-toggle="delete-modal-{{ $account->id }}"
                                                                    type="submit"
                                                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                                    Sim, tenho certeza.
                                                                </button>
                                                            </form>

                                                            <button
                                                                data-modal-toggle="delete-modal-{{ $account->id }}"
                                                                type="button"
                                                                class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                                Não, cancelar.
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $accounts }}
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
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Inserir Conta</h3>
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
                    <form method="POST" action="{{ route('accounts.store') }}">
                        @csrf
                        <div class="grid grid-cols-2 gap-5 justify-center">

                            <div class="mb-5">
                                <label for="cpf"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cliente</label>
                                <select id="cpf" name="cpf"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="" selected disabled>Selecione o cliente</option>
                                    @foreach($customers as $customer)
                                        <option value="{{$customer->cpf}}">{{$customer->nome}} {{ $customer->sobrenome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-5">
                                <label for="cpf-2"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cliente Conjunto</label>
                                <select id="cpf-2" name="cpf-2"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" selected >Selecione o cliente (Opcional)</option>
                                    @foreach($customers as $customer)
                                        <option value="{{$customer->cpf}}">{{$customer->nome}} {{ $customer->sobrenome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-5">
                                <label for="agencia_id"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Agência</label>
                                <select id="agencia_id" name="agencia_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="" selected disabled>Selecione a Agência</option>
                                    @foreach($agencies as $agency)
                                        <option value="{{$agency->id}}">{{$agency->nome}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-5">
                                <label for="gerente_id"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gerente</label>
                                <select id="gerente_id" name="gerente_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="" selected disabled>Selecione o Gerente</option>
                                    @foreach($managers as $manager)
                                        <option value="{{$manager->id}}">{{$manager->nome}} {{$manager->sobrenome}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-5">
                                <label for="password"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Senha</label>
                                <input type="password" id="password" name="password"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       required>
                            </div>

                            <div class="mb-5">
                                <label for="tipo"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de Conta</label>
                                <select id="tipo" name="tipo"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="" selected disabled>Selecione o tipo de conta</option>
                                    @foreach(AccountTypeEnum::toArray() as $key => $type)
                                        <option value="{{$key}}">{{$type}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-5">
                                <label id="juros-label" for="juros"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Juros</label>
                                <input type="number" id="juros" name="juros" step="0.01"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                >
                            </div>

                            <div class="mb-5">
                                <label id="limite_credito-label" for="limite_credito"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Limite de Crédito</label>
                                <input type="number" id="limite_credito" name="limite_credito" step="0.01"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                >
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function updateInputsAndLabels() {
                var tipoSelect = document.getElementById('tipo');
                var jurosInput = document.getElementById('juros');
                var limiteCreditoInput = document.getElementById('limite_credito');
                var jurosLabel = document.getElementById('juros-label');
                var limiteCreditoLabel = document.getElementById('limite_credito-label');

                jurosInput.removeAttribute('disabled');
                limiteCreditoInput.removeAttribute('disabled');

                switch (tipoSelect.value) {
                    case 'CC':
                        jurosInput.setAttribute('disabled', 'disabled');
                        limiteCreditoInput.setAttribute('disabled', 'disabled');
                        jurosLabel.classList.remove('text-gray-900');
                        jurosLabel.classList.add('text-gray-500');
                        limiteCreditoLabel.classList.remove('text-gray-900');
                        limiteCreditoLabel.classList.add('text-gray-500');
                        break;
                    case 'CP':
                        limiteCreditoInput.setAttribute('disabled', 'disabled');
                        limiteCreditoLabel.classList.remove('text-gray-900');
                        limiteCreditoLabel.classList.add('text-gray-500');
                        jurosLabel.classList.remove('text-gray-500');
                        jurosLabel.classList.add('text-gray-900');
                        break;
                    case 'CE':
                        jurosInput.setAttribute('disabled', 'disabled');
                        jurosLabel.classList.remove('text-gray-900');
                        jurosLabel.classList.add('text-gray-500');
                        limiteCreditoLabel.classList.remove('text-gray-500');
                        limiteCreditoLabel.classList.add('text-gray-900');
                        break;
                    default:
                        jurosLabel.classList.remove('text-gray-500');
                        jurosLabel.classList.add('text-gray-900');
                        limiteCreditoLabel.classList.remove('text-gray-500');
                        limiteCreditoLabel.classList.add('text-gray-900');
                        break;
                }
            }

            document.getElementById('tipo').addEventListener('change', updateInputsAndLabels);

            updateInputsAndLabels();
        });
    </script>

@endsection
