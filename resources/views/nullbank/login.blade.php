@extends('layouts.home-app')

@section('content')

    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
                Nullbank
            </a>
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Entre na sua conta
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
                    <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('customer.login') }}">
                        @csrf
                        <div>
                            <label for="cpf"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">CPF</label>
                            <input type="text" maxlength="13" minlength="13" id="cpf" name="cpf"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="123.456.789-09" required pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
                                   oninput="formatarCPF(this)">
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Senha</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                        </div>
                        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login</button>
{{--                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">--}}
{{--                            Não tem uma conta ainda? <a href="#" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Cadastre-se já!</a>--}}
{{--                        </p>--}}
                    </form>
                </div>


            </div>


        </div>

        <script>
            function formatarCPF(campo) {
                campo.value = campo.value.replace(/\D/g, ""); // Remove caracteres não numéricos
                campo.value = campo.value.replace(/(\d{3})(\d)/, "$1.$2"); // Adiciona ponto após os primeiros 3 dígitos
                campo.value = campo.value.replace(/(\d{3})(\d)/, "$1.$2"); // Adiciona ponto após os segundos 3 dígitos
                campo.value = campo.value.replace(/(\d{3})(\d{2})$/, "$1-$2"); // Adiciona traço após os últimos 2 dígitos
            }
        </script>
    </section>


@endsection
