@php use App\Enums\EmployeeTypeEnum;use App\Enums\UserPronoumEnum;use App\NullBankModels\Endereco;use App\NullBankModels\Usuario;use Carbon\Carbon;use Illuminate\Support\Facades\Hash; @endphp
@extends('layouts.app')

@section('content')

    <div class="ml-64">
        @php
            $user = Usuario::first($employee->usuario_id);
            $address = Endereco::first($user->endereco_id);
        @endphp

        <div
            class="mx-10 mt-10 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">

            <h3 class="text-3xl font-bold dark:text-white mb-5">{{ $user->pronomes == UserPronoumEnum::SHE->value ? 'Funcionária' : 'Funcionário' }} {{ $user->nome }} {{ $user->sobrenome }}</h3>

            <form method="POST" action="{{ route('employees.update', $employee->id) }}">
                @csrf
                @method('PUT')
                <div class="flex justify-center">
                    <div class="grid grid-cols-3 gap-8 max-w-screen-lg">
                        <div>
                            <div class="mb-5">
                                <label for="nome"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white w-full">Seu
                                    nome</label>
                                <input type="text" id="nome" name="nome"
                                       value=" {{ $user->nome }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="Matheus" required>
                            </div>

                            <div class="mb-5">
                                <label for="sobrenome"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Seu
                                    sobrenome</label>
                                <input type="text" id="sobrenome" name="sobrenome"
                                       value=" {{ $user->sobrenome }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="Fares" required>
                            </div>

                            <div class="mb-5">
                                <label for="pronomes"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Seus
                                    pronomes</label>
                                <select id="pronomes" name="pronomes"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected disabled>Selecione</option>
                                    <option value="ele/dele" {{ $user->pronomes == 'ele/dele' ? 'selected' : '' }}>
                                        Ele/Dele
                                    </option>
                                    <option value="ela/dela" {{ $user->pronomes == 'ela/dela' ? 'selected' : '' }}>
                                        Ela/Dela
                                    </option>
                                    <option value="neutros" {{ $user->pronomes == 'neutros' ? 'selected' : '' }}>
                                        Neutro
                                    </option>
                                </select>
                            </div>

                            <div class="mb-5">
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Seu
                                    email</label>
                                <input type="email" id="email" name="email"
                                       value=" {{ $user->email }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="email@fares.com" required>
                            </div>

                            <div class="mb-5">
                                <label for="password"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nova senha</label>
                                <input type="password" id="password" name="password"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>

                            <div class="mb-5">
                                <label for="nascido_em" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sua data de nascimento</label>
                                <div class="relative max-w-sm">
                                    <div
                                        class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                    </div>

                                    <input datepicker-format="yyyy/mm/dd" id="nascido_em" name="nascido_em" datepicker type="text"
                                           value=" {{ Carbon::make($user->nascido_em)->format('Y/m/d') }}"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           placeholder="Selecione a data"
                                    >
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-5">
                                <label for="agencia_id"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Agência</label>
                                <select id="agencia_id" name="agencia_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required>
                                    <option value="" selected disabled>Selecione a agência</option>
                                    @foreach($agencies as $agency)
                                        <option value="{{$agency->id}}" {{ $employee->agencia_id == $agency->id ? 'selected' : '' }}>{{$agency->nome}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-5">
                                <label for="matricula"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Matrícula</label>
                                <input type="text" id="matricula" name="matricula"
                                       value="{{ $employee->matricula }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="123ABC" required>
                            </div>

                            <div class="mb-5">
                                <label for="senha_corporativa"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nova senha
                                    corporativa</label>
                                <input type="password" id="senha_corporativa" name="senha_corporativa"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="">
                            </div>

                            <div class="mb-5">
                                <label for="cargo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargo</label>
                                <select id="cargo" name="cargo"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required>
                                    <option value="" selected disabled>Selecione o cargo</option>
                                    @foreach(EmployeeTypeEnum::toArray() as $key => $employeeType)
                                        <option value="{{$key}}" {{ $employee->cargo == $key ? 'selected' : '' }}>{{$employeeType}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-5">
                                <label for="salario"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Salário</label>
                                <input type="text" id="salario" name="salario"
                                       value="{{ $employee->salario }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="3000.00" required>
                            </div>

                            <div></div>
                        </div>

                        <div>
                            <div class="mb-5">
                                <label for="cep" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">CEP</label>
                                <input type="text" id="cep" name="cep"
                                       value="{{$address->cep}}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="12345-678" required>
                            </div>

                            <div class="mb-5">
                                <label for="logradouro_tipo_id"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de Logradouro</label>
                                <select id="logradouro_tipo_id" name="logradouro_tipo_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required>
                                    @foreach($streetTypes as $streetType)
                                        <option value="{{$streetType->id}}" {{$streetType->id == $address->logradouro_tipo_id ? 'selected' : ''}}>{{$streetType->nome}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-5">
                                <label for="logradouro"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Logradouro</label>
                                <input placeholder="Rua Menino Deus" type="text" id="logradouro" name="logradouro"
                                       value="{{ $address->logradouro }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       required>
                            </div>

                            <div class="mb-5">
                                <label for="numero"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Número</label>
                                <input placeholder="1010" type="text" id="numero" name="numero"
                                       value="{{ $address->numero }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       required>
                            </div>

                            <div class="mb-5">
                                <label for="bairro"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bairro</label>
                                <input placeholder="Campo dos Velhos" type="text" id="bairro" name="bairro"
                                       value="{{ $address->bairro }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       required>
                            </div>

                            <div class="mb-5">
                                <label for="cidade"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cidade</label>
                                <input placeholder="Sobral" type="text" id="cidade" name="cidade"
                                       value="{{ $address->cidade }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       required>
                            </div>

                            <div class="mb-5">
                                <label for="estado"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                                <input placeholder="CE" type="text" id="estado" name="estado"
                                       value="{{ $address->estado }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       required>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="flex flex-row items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                    <a href=" {{ route('employees.index') }}" type="button"
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

    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var dateInput = document.getElementById('nascido_em');
            var dateValue = dateInput.value.trim();

            var formattedDate = moment(dateValue).format('YYYY/MM/DD');

            dateInput.value = formattedDate;
        });
    </script>
@endsection
