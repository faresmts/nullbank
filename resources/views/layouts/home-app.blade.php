@extends('layouts.base')

@section('body')

    <div>
        @yield('content')

        @isset($slot)
            {{ $slot }}
        @endisset
    </div>

@endsection
