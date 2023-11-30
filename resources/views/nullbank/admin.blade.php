@extends('layouts.home-app')

@section('content')

    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="h-24 mr-2" src="{{ asset('logo.png') }}" alt="logo">
            </a>

            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Entre como administrador
                    </h1>
                    @if(Session::has('error'))
                        <div id="error-popup" class="bg-red-300 rounded text-center text-gray-800 py-2">
                            {{ Session::get('error') }}
                        </div>

                        <script>
                            setTimeout(function() {
                                var errorPopup = document.getElementById('error-popup');
                                if (errorPopup) {
                                    errorPopup.style.transition = 'opacity 2s ease-in-out';
                                    errorPopup.style.opacity = '0';
                                    setTimeout(function() {
                                        errorPopup.style.display = 'none';
                                    }, 2000);
                                }
                            }, 5000);
                        </script>
                    @endif
                    <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('admin.login') }}">
                        @csrf
                        <div>
                            <label for="user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usuário</label>
                            <input type="text" name="user" id="user" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="admin-user" required="">
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Senha</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                        </div>
                        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login</button>
                    </form>

                    <div class="flex justify-between">
                        <a href="{{ route('customer') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-500" wire:navigate>Acesso para Clientes</a>
                        <a href="{{ route('employee') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-500" wire:navigate>Acesso para Funcionários</a>
                    </div>
                </div>
            </div>


        </div>
    </section>


@endsection
