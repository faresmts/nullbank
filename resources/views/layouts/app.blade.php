@extends('layouts.base')

@section('body')

    @include('layouts.nav')

    <div class="sm:ml-auto">
        @yield('content')

        @isset($slot)
            {{ $slot }}
        @endisset
    </div>




@endsection
