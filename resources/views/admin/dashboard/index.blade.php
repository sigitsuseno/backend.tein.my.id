@extends('layouts.dash')

@section('content')
    @push('header')
        <div class="w-full h-full px-3 flex items-center justify-start lg:bg-white">
            <div>test</div>
        </div>
    @endpush
    <div class="w-full grid grid-cols-1 md:grid-cols-[250px_1fr]">
        <div>
            @include('layouts.partials.aside')
        </div>
        <div class="p-6 bg-putih">
            <div>
                @include('admin.dashboard.shortcut')
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-4 py-1 rounded-lg bg-light cursor-pointer">Logout</button>
            </form>
            @auth
                {{ Auth::user()->username }}
            @endauth
            <div class="w-full h-screen">test</div>
            <div class="w-full h-screen">test</div>
        </div>
    </div>
@endsection
@section('js')
@endsection
