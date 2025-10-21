@extends('layouts.dash')

@section('content')
    @push('header')
        <div class="w-full h-full px-3 flex items-center justify-start lg:bg-white">
            <div>test</div>
        </div>
    @endpush
    <div class="w-full grid grid-cols-1 md:grid-cols-[250px_1fr]">
        <div>
            @include('layouts.partials.aside-member')
        </div>
        <div class="p-3 md:p-6 bg-putih">
            @include('member.dashboard.shortcut-menu')
        </div>
    </div>
@endsection
@section('js')
@endsection
