<aside
    class="bg-gradient-to-tr from-panel to-light fixed top-0 -left-full lg:left-0 w-[250px] h-[calc(100vh)] lg:h-[calc(100vh)] z-60 ">
    <div class="sidmenu">
        <div class="w-full h-12 lg:h-14 flex items-center justify-center px-3 ">
            @if (Auth::user()->type === 'admin')
                <a href="/admin/dashboard">
                    <img src="{{ $main_logo }}" alt="" class="h-6 lg:h-8">
                </a>
            @else
                <a href="/{{ Auth::user()->username ?? Auth::user()->uuid }}/dashboard">
                    <img src="{{ $main_logo }}" alt="" class="h-6 lg:h-8">
                </a>
            @endif
        </div>
        <!-- profile -->
        <div class="px-3 mt-6">
            <div
                class="w-full p-2 rounded-xl shadow bg-indigo-50 lg:bg-gradient-to-tr from-primary to-secondary relative">
                <!-- Avatar -->
                <div class="grid grid-cols-[60px_1fr] items-center ">
                    <div class="w-full aspect-square rounded-xl bg-blue-200">

                    </div>
                    <div class="text-black lg:text-white pl-3 text-left">
                        <div class="">
                            <h3 class="text-xl lg:text-base/5 line-clamp-2 font-bold uppercase">
                                {{ Auth::user()->name }}

                            </h3>
                        </div>
                        <div>
                            <p class="text-xs line-clamp-2 text-blue-950 font-bold">{{ Auth::user()->type }}</p>
                        </div>
                    </div>
                </div>
                <div class="absolute right-3 bottom-0">
                    <div class="group relative inline-block">
                        <button id="profile_dropdown_btn" type="button"
                            class="cursor-pointer absolute bottom-0 right-0">
                            <i class='bx bx-cog text-2xl -pb-1'></i>
                        </button>

                        <div id="profile-dropdown-menu"
                            class="dropdown_profile_menu p-2 rounded-lg bg-blue-50 shadow absolute top-0 right-0 min-w-20 hidden">

                            <a href="#" class="px-3 py-1 hover:bg-white block">Profile</a>
                            <a href="#" class="px-3 py-1 hover:bg-white block">Setting</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Menu -->
        <div class="px-3">
            <div class="shadow shadow-primary w-full rounded-lg mt-4 bg-gradient-to-b from-secondary to-primary ">
                <div class="w-full h-10 flex items-center rounded-lg text-white px-3.5">
                    <i class='bx bx-menu text-xl mb-0.5 mr-1'></i> MENU
                </div>
                <div class="w-full px-2 pb-2 rounded-lg space-y-2">
                    <a href="{{ route('admin.dashboard') }}"
                        class="h-10 flex items-center justify-start gap-2  rounded-md px-2 hover:bg-light transition-colors duration-500 {{ request()->routeIs('admin.dashboard') ? 'bg-light' : 'bg-white' }}">
                        <i class='bx bxs-dashboard text-3xl'></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.user-manager.index') }}"
                        class="h-10 flex items-center justify-start gap-2  rounded-md px-2 hover:bg-light transition-colors duration-500 {{ request()->routeIs('admin.user-manager.*') ? 'bg-light' : 'bg-white' }}">
                        <i class='bx bxs-user-rectangle text-3xl'></i>
                        <span>User Manager</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full h-10 flex items-center justify-start gap-2 bg-white rounded-md px-2 hover:bg-light transition-colors duration-500 cursor-pointer">
                            <i class='bx bx-log-out text-3xl'></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</aside>
