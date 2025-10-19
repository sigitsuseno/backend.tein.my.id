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
    <div class="flex items-center justify-center min-h-screen bg-secondary px-4">
        <div class="text-center p-4 bg-white shadow-lg rounded-lg">
            <h1 class="text-9xl font-extrabold text-yellow-600 tracking-widest">
                404
            </h1>
            <div
                class="bg-red-600 px-2 text-sm rounded absolute rotate-12 left-1/2 -translate-x-1/2 text-white animate-bounce">
                Halaman Tidak ada
            </div>
            <p class="text-gray-500 mt-8">
                Maaf, Halaman yang anda akses tidak ditemukan.
            </p>
            <button class="mt-5">
                <a href="{{ url()->previous() }}"
                    class="relative inline-block text-sm font-medium text-yellow-600 group active:text-yellow-500 focus:outline-none focus:ring">
                    <span
                        class="absolute inset-0 transition-transform translate-x-0.5 translate-y-0.5 bg-yellow-600 group-hover:translate-y-0 group-hover:translate-x-0"></span>
                    <span class="relative block px-8 py-3 bg-[#FFFFFF] border border-current">
                        Kembali
                    </span>
                </a>
            </button>
        </div>
    </div>
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/dash.js') }}"></script>
    @yield('js')
</body>

</html>
