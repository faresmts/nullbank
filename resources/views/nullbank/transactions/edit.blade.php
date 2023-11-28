@extends('layouts.app')

@section('content')

    <div class="ml-64">

        <div
            class="mx-10 mt-10 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">

            <h3 class="text-3xl font-bold dark:text-white mb-5">Endereço {{ $address->logradouro }} {{ $address->numero }}</h3>

            <form method="POST" action="{{ route('addresses.update', $address->id) }}">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-5 justify-center">
                    <div class="mb-5">
                        <label for="cep"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">CEP</label>
                        <input type="text" id="cep" name="cep"
                               value=" {{ $address->cep  }}"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="12345-678" required>
                    </div>

                    <div class="mb-5">
                        <label for="logradouro_tipo_id"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de
                            Logradouro</label>
                        <select id="logradouro_tipo_id" name="logradouro_tipo_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="" selected disabled>Selecione o tipo</option>
                            @foreach($streetTypes as $streetType)
                                <option value="{{$streetType->id}}" {{ $streetType->id == $address->logradouro_tipo_id ? 'selected' : ''}}>{{$streetType->nome}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="logradouro"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Logradouro</label>
                        <input type="text" id="logradouro" name="logradouro"
                               value=" {{ $address->logradouro }}"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               required>
                    </div>

                    <div class="mb-5">
                        <label for="numero"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Número</label>
                        <input type="text" id="numero" name="numero"
                               value=" {{ $address->numero }}"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               required>
                    </div>

                    <div class="mb-5">
                        <label for="bairro"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bairro</label>
                        <input type="text" id="bairro" name="bairro"
                               value=" {{ $address->bairro }}"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               required>
                    </div>

                    <div class="mb-5">
                        <label for="cidade"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cidade</label>
                        <input type="text" id="cidade" name="cidade"
                               value=" {{ $address->cidade }}"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               required>
                    </div>

                    <div class="mb-5">
                        <label for="estado"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                        <input type="text" id="estado" name="estado"
                               value=" {{ $address->estado }}"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               required>
                    </div>
                </div>

                <div class="flex flex-row items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                    <a href=" {{ route('addresses.index') }}" type="button"
                       class="py-2 px-4 = text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                    >
                        <i class="fa-solid fa-chevron-left"></i> Retornar
                    </a>
                    <button type="submit"
                            class="w-full px-4 py-2 md:w-auto flex items-center justify-center text-sm text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        <i class="fa-solid fa-pen-to-square mr-2"></i> Editar
                    </button>
                </div>
            </form>
        </div>


    </div>



    <script>
        document.getElementById('cep').addEventListener('blur', function () {
            var cep = this.value.replace('-', '');
            if (cep.length === 8) {
                fetch('https://viacep.com.br/ws/' + cep + '/json/')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('logradouro').value = data.logradouro;
                        document.getElementById('bairro').value = data.bairro;
                        document.getElementById('cidade').value = data.localidade;
                        document.getElementById('estado').value = data.uf;
                    })
                    .catch(error => console.error('Erro ao buscar CEP:', error));
            }
        });
    </script>
@endsection
