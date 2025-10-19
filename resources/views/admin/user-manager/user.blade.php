@extends('layouts.dash')

@section('content')
    @push('header')
        <div class="w-full h-full px-3 flex items-center justify-start lg:bg-white">
            <div class="w-8 h-8 rounded-md mr-3 flex items-center justify-center shadow hover:bg-primary/10">
                <a href="/admin/dashboard" class=" flex items-center justify-center"><i
                        class='bx bx-left-arrow-alt text-3xl'></i></a>
            </div>
            <div>
                <a href="/admin/user-manager">User Manager</a>
            </div>
        </div>
    @endpush
    <div class="w-full grid grid-cols-1 md:grid-cols-[250px_1fr]">
        <div>
            @include('layouts.partials.aside')
        </div>
        <div class="p-3 md:p-6 bg-putih">

            <div class="w-full md:w-fit rounded-xl bg-white overflow-hidden p-1.5">
                @include('admin.user-manager.userm-menu')
            </div>
            <div class="w-full bg-white mt-4 rounded-xl p-4">
                test
            </div>

        </div>
    </div>
@endsection
@section('js')
@endsection
