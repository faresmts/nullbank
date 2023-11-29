@php use App\Enums\AccountTypeEnum;use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')

    <div class="ml-64">

        <div
            class="mx-10 mt-10 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">

            <h3 class="text-3xl font-bold dark:text-white mb-5">Editar Conta {{$account->id}}</h3>

            <form method="POST" action="{{ route('managers.accounts.update', [$manager->id, $account->id]) }}">
                @csrf
                @method('PUT')
                @php
                    $accountCustomers = $account->getClientes();
                    $accountCustomersIds = [];
                    foreach ($accountCustomers as $accountCustomer) {
                        $accountCustomersIds[] = $accountCustomer->cpf;
                    }
                @endphp
                <div class="grid grid-cols-2 gap-5 justify-center">
                    <div class="mb-5">
                        <label for="cpf"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cliente</label>
                        <select id="cpf" name="cpf"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                            <option value="" selected disabled>Selecione o cliente</option>
                            @foreach($customers as $customer)
                                <option
                                    value="{{$customer->cpf}}" {{ isset($accountCustomersIds[0]) && $customer->cpf == $accountCustomersIds[0] ? 'selected' : ''}}>{{$customer->nome}} {{ $customer->sobrenome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="cpf-2"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cliente
                            Conjunto</label>
                        <select id="cpf-2" name="cpf-2"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" selected>Selecione o cliente (Opcional)</option>
                            @foreach($customers as $customer)
                                <option
                                    value="{{$customer->cpf}}" {{ isset($accountCustomersIds[1]) && $customer->cpf == $accountCustomersIds[1] ? 'selected' : ''}}>{{$customer->nome}} {{ $customer->sobrenome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="agencia_id"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Agência</label>
                        <input readonly type="text" id="agencia_id" name="agencia_id"
                               value="{{str_pad($manager->agencia_id, 5, '0', STR_PAD_LEFT) }}"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               required>
                    </div>

                    <div class="mb-5">
                        <label for="password"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Redefinir Senha</label>
                        <input type="password" id="password" name="password"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>

                    <div class="mb-5">
                        <label for="tipo"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de
                            Conta</label>
                        <select id="tipo" name="tipo"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                            <option value="" selected disabled>Selecione o tipo de conta</option>
                            @foreach(AccountTypeEnum::toArray() as $key => $type)
                                <option value="{{$key}}" {{$key == $account->tipo ? 'selected' : ''}}>{{$type}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-5">
                        <label id="aniversario-label" for="aniversario" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Aniversário da conta</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>

                            <input datepicker-format="yyyy/mm/dd" id="aniversario" name="aniversario" datepicker type="text"
                                   value=" {{ is_null($account->aniversario) ? Carbon::make($account->created_at)->format('Y/m/d') :  Carbon::make($account->aniversario)->format('Y/m/d') }}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="Selecione a data"
                            >
                        </div>
                    </div>

                    <div class="mb-5">
                        <label id="juros-label" for="juros"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Juros</label>
                        <input type="number" id="juros" name="juros" step="0.01"
                               value="{{ $account->juros > 0 ? number_format($account->juros, 2, '.') : '' }}"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                    </div>

                    <div class="mb-5">
                        <label id="limite_credito-label" for="limite_credito"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Limite de
                            Crédito</label>
                        <input
                            value="{{ $account->limite_credito > 0 ? number_format($account->limite_credito, 2, ',', '.') : ''}}"
                            type="number" id="limite_credito" name="limite_credito" step="0.01"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                    </div>

                </div>

                <div class="flex flex-row items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                    <a href=" {{ route('managers.accounts.index', $manager->id) }}" type="button"
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
        document.addEventListener('DOMContentLoaded', function () {
            var tipoSelect = document.getElementById('tipo');
            var jurosInput = document.getElementById('juros');
            var limiteCreditoInput = document.getElementById('limite_credito');
            var aniversarioInput = document.getElementById('aniversario');
            var aniversarioLabel = document.getElementById('aniversario-label');
            var jurosLabel = document.getElementById('juros-label');
            var limiteCreditoLabel = document.getElementById('limite_credito-label');

            function disableInputsAndChangeLabels(disableJuros, disableLimiteCredito, disableAniversario) {
                jurosInput.disabled = disableJuros;
                limiteCreditoInput.disabled = disableLimiteCredito;
                aniversarioInput.disabled = disableAniversario;

                jurosLabel.classList.toggle('text-gray-900', !disableJuros);
                jurosLabel.classList.toggle('text-gray-500', disableJuros);
                jurosInput.classList.toggle('text-gray-900', !disableJuros);
                jurosInput.classList.toggle('text-gray-500', disableJuros);

                limiteCreditoLabel.classList.toggle('text-gray-900', !disableLimiteCredito);
                limiteCreditoLabel.classList.toggle('text-gray-500', disableLimiteCredito);
                limiteCreditoInput.classList.toggle('text-gray-900', !disableLimiteCredito);
                limiteCreditoInput.classList.toggle('text-gray-500', disableLimiteCredito);

                aniversarioInput.classList.toggle('text-gray-900', !disableAniversario);
                aniversarioInput.classList.toggle('text-gray-500', disableAniversario);
                aniversarioLabel.classList.toggle('text-gray-900', !disableAniversario);
                aniversarioLabel.classList.toggle('text-gray-500', disableAniversario);
            }

            function updateInputsAndLabels() {
                var selectedOption = tipoSelect.value;

                switch (selectedOption) {
                    case 'CC':
                        disableInputsAndChangeLabels(true, true, false);
                        break;
                    case 'CP':
                        disableInputsAndChangeLabels(false, true, true);
                        break;
                    case 'CE':
                        disableInputsAndChangeLabels(true, false, true);  // Agora desabilita o campo 'aniversario' também
                        break;
                    default:
                        disableInputsAndChangeLabels(false, false, false);
                        break;
                }
            }

            tipoSelect.addEventListener('change', updateInputsAndLabels);

            updateInputsAndLabels();
        });

    </script>

    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var dateInput = document.getElementById('aniversario');
            var dateValue = dateInput.value.trim();

            if (dateValue !== null && dateValue !== '') {
                var formattedDate = moment(dateValue).format('YYYY/MM/DD');
                dateInput.value = formattedDate;
            }
        });
    </script>

@endsection
