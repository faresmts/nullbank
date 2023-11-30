@php
    use App\NullBankModels\Cliente;use App\NullBankModels\Funcionario;
    if ($_SESSION['user_type'] == 'employee') {
        $employee = Funcionario::first($_SESSION['user_id']);
    }

    if ($_SESSION['user_type'] == 'customer') {
        $customer = Cliente::first($_SESSION['user_id']);
    }
@endphp


@section('body')
    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
            type="button"
            class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
             xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                  d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
    </button>

    <aside id="logo-sidebar"
           class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
           aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">

            <a href=" {{ route('home') }}" class="flex items-center ps-2.5 mb-5">
                <img class="h-10 mr-2" src="{{ asset('logo.png') }}" alt="logo">
            </a>


            @switch($_SESSION['user_type'])
                @case('customer')
                    @include('layouts.customer-nav')
                    @break
                @case('employee')
                    @include('layouts.employee-nav')
                    @break
                @case('admin')
                    @include('layouts.admin-nav')
                    @break
            @endswitch

        </div>
    </aside>

    <div class="sm:ml-auto">
        @yield('content')

        @isset($slot)
            {{ $slot }}
        @endisset
    </div>
@endsection
