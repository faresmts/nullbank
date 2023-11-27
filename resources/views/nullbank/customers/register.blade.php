@extends('layouts.app')

@section('content')

    <div class="flex items-center justify-center h-screen">

        <form method="POST" action="{{ route('customers.store') }}" class="max-w-3xl mx-auto">
            @csrf

            <div class="flex justify-center">
                <div class="grid grid-cols-3 gap-8 max-w-screen-lg">
                    <div>
                        <div class="mb-5">
                            <label for="nome" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white w-full">Seu nome</label>
                            <input type="text" id="nome" name="nome" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Matheus" required>
                        </div>

                        <div class="mb-5">
                            <label for="sobrenome" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Seu sobrenome</label>
                            <input type="text" id="sobrenome" name="sobrenome" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Fares" required>
                        </div>

                        <div class="mb-5">
                            <label for="pronomes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Seus pronomes</label>
                            <select id="pronomes" name="pronomes" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>Selecione </option>
                                <option value="ele/dele">Ele/Dele</option>
                                <option value="ela/dela">Ela/Dela</option>
                                <option value="neutros">Neutro</option>
                            </select>
                        </div>

                        <div class="mb-5">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Seu email</label>
                            <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="email@fares.com" required>
                        </div>

                        <div class="mb-5">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sua senha</label>
                            <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>

                        <div class="mb-5">
                            <label for="nascido_em" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sua data de nascimento</label>
                            <div class="relative max-w-sm">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                <input id="nascido_em" name="nascido_em" datepicker type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Selecione a data">
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="mb-5">
                            <label for="cpf" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">CPF</label>
                            <input type="text" maxlength="13" minlength="13" id="cpf" name="cpf" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="123.456.789-09" required pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" oninput="formatarCPF(this)">
                        </div>

                        <div class="mb-5">
                            <label for="rg" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Seu RG</label>
                            <input type="number" id="rg" name="rg" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="123123" required>
                        </div>

                        <div class="mb-5">
                            <label for="rg_emitido_por" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">RG emitido por: </label>
                            <input type="text" id="rg_emitido_por" name="rg_emitido_por" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="SSP" required>
                        </div>

                        <div class="mb-5">
                            <label for="uf" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">UF</label>
                            <select id="uf" name="uf" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" selected disabled>Selecione o estado</option>
                                <option value="AC">Acre</option>
                                <option value="AL">Alagoas</option>
                                <option value="AP">Amapá</option>
                                <option value="AM">Amazonas</option>
                                <option value="BA">Bahia</option>
                                <option value="CE">Ceará</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="ES">Espírito Santo</option>
                                <option value="GO">Goiás</option>
                                <option value="MA">Maranhão</option>
                                <option value="MT">Mato Grosso</option>
                                <option value="MS">Mato Grosso do Sul</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="PA">Pará</option>
                                <option value="PB">Paraíba</option>
                                <option value="PR">Paraná</option>
                                <option value="PE">Pernambuco</option>
                                <option value="PI">Piauí</option>
                                <option value="RJ">Rio de Janeiro</option>
                                <option value="RN">Rio Grande do Norte</option>
                                <option value="RS">Rio Grande do Sul</option>
                                <option value="RO">Rondônia</option>
                                <option value="RR">Roraima</option>
                                <option value="SC">Santa Catarina</option>
                                <option value="SP">São Paulo</option>
                                <option value="SE">Sergipe</option>
                                <option value="TO">Tocantins</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <div class="mb-5">
                            <label for="cep" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">CEP</label>
                            <input type="text" id="cep" name="cep" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="12345-678" required>
                        </div>

                        <div class="mb-5">
                            <label for="logradouro_tipo_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de Logradouro</label>
                            <select id="logradouro_tipo_id" name="logradouro_tipo_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" selected disabled>Selecione o tipo</option>
                                @foreach($logradouroTipos as $logradouroTipo)
                                    <option value="{{$logradouroTipo->id}}">{{$logradouroTipo->nome}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-5">
                            <label for="logradouro" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Logradouro</label>
                            <input type="text" id="logradouro" name="logradouro" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>

                        <div class="mb-5">
                            <label for="numero" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Número</label>
                            <input type="text" id="numero" name="numero" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>

                        <div class="mb-5">
                            <label for="bairro" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bairro</label>
                            <input type="text" id="bairro" name="bairro" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>

                        <div class="mb-5">
                            <label for="cidade" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cidade</label>
                            <input type="text" id="cidade" name="cidade" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>

                        <div class="mb-5">
                            <label for="estado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                            <input type="text" id="estado" name="estado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            </div>
        </form>



    </div>

    <script>
        function formatarCPF(campo) {
            campo.value = campo.value.replace(/\D/g, ""); // Remove caracteres não numéricos
            campo.value = campo.value.replace(/(\d{3})(\d)/, "$1.$2"); // Adiciona ponto após os primeiros 3 dígitos
            campo.value = campo.value.replace(/(\d{3})(\d)/, "$1.$2"); // Adiciona ponto após os segundos 3 dígitos
            campo.value = campo.value.replace(/(\d{3})(\d{2})$/, "$1-$2"); // Adiciona traço após os últimos 2 dígitos
        }

        document.getElementById('cep').addEventListener('blur', function() {
            var cep = this.value.replace('-', '');
            if (cep.length === 8) {
                fetch('https://viacep.com.br/ws/' + cep + '/json/')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('logradouro').value = data.logradouro;
                        document.getElementById('numero').value = ''; // Preencha com o número se tiver essa informação disponível na resposta da API
                        document.getElementById('bairro').value = data.bairro;
                        document.getElementById('cidade').value = data.localidade;
                        document.getElementById('estado').value = data.uf;
                    })
                    .catch(error => console.error('Erro ao buscar CEP:', error));
            }
        });
    </script>
@endsection
