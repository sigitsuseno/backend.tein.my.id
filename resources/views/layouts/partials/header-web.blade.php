<header class="w-fit  fixed top-0 right-0 p-4">
    @guest
        <a href="/login"
            class="flex items-center justify-center w-20 h-10 rounded-lg bg-primary text-white hover:bg-primary/80 transition-colors duration-500">Login</a>
    @endguest
    @auth
        @if (Auth::user()->hasRole(['superadmin', 'admin', 'dokter', 'operator']))
            <a href="/admin/dashboard"
                class="flex items-center justify-center w-20 h-10 rounded-lg bg-primary text-white hover:bg-primary/80 transition-colors duration-500">dashboard</a>
        @else
            <a href="/{{ $keyname }}/dashboard"
                class="flex items-center justify-center w-20 h-10 rounded-lg bg-primary text-white hover:bg-primary/80 transition-colors duration-500">dashboard</a>
        @endif
    @endauth
</header>
