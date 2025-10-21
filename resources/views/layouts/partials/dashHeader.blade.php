<header id="mainHeader"
    class="fixed top-0 left-0 right-0 w-full h-12 lg:h-14  flex justify-center items-center bg-transparent transition duration-300 lg:border-b lg:border-putih z-50 lg:pl-[250px]">
    <div class="w-full grid grid-cols-2 md:grid-cols-[60%_40%] pr-3">
        @stack('header')
        <div class="flex items-center justify-end space-x-4 pr-0 md:pr-5">
            <div class="relative">
                <i class="bx bxs-bell-ring text-gray-500 text-3xl"></i>
                <span
                    class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center">3</span>
            </div>
            @if (Auth::user()->hasRole(['superadmin', 'admin', 'dokter', 'operator']))
                <a href="{{ route('member.profile.index', $keyname) }}" class="flex items-center space-x-3">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=150&q=80"
                        alt="Profile" class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <p class="text-sm lg:text-base font-medium text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs lg:text-sm text-gray-500">{{ Auth::user()->roles[0]->name }}</p>
                    </div>
                </a>
            @else
                <a href="{{ route('member.profile.index', $keyname) }}" class="flex items-center space-x-3 md:hidden">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=150&q=80"
                        alt="Profile" class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <p class="text-sm lg:text-base font-medium text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs lg:text-sm text-gray-500">{{ Auth::user()->roles[0]->name }}</p>
                    </div>
                </a>
            @endif

        </div>
    </div>
</header>
