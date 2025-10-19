<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('assets/boxicons/css/boxicons.min.css') }}" rel="stylesheet" />
    <title>{{ $nama_app }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('css')
</head>

<body class="relative">
    <div id="body_frame" class="w-full h-screen overflow-hidden">

        @include('layouts.partials.dashHeader')

        <main id="main-scroll-area" class="w-full h-screen pt-12 lg:pt-14 overflow-y-auto bg-putih">
            @yield('content')
        </main>

    </div>
    @yield('modal')
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/dash.js') }}"></script>
    @yield('js')
</body>

</html>
