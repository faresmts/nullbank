@extends('layouts.base')

@section('body')

    @include('layouts.nav')

    <div class="sm:ml-64">
        @yield('content')

        @isset($slot)
            {{ $slot }}
        @endisset
    </div>




@endsection
