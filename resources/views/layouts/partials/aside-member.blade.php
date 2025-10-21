<aside
    class="bg-gradient-to-tr from-panel to-light fixed top-0 -left-full md:left-0 w-[250px] h-[calc(100vh)] lg:h-[calc(100vh)] z-60 ">
    <div class="sidmenu">
        <div class="w-full aspect-[6/3] flex flex-col items-center justify-center px-3 mt-3">

            <a href="/{{ $keyname }}/dashboard">
                <img src="{{ $main_logo }}" alt="" class="h-12">
            </a>


            {{-- <div
                class="w-full py-2 rounded-md flex flex-col items-center justify-center bg-gradient-to-bl from-secondary to-contras2 text-xl font-bold text-white mt-4">
                <p>{{ Auth::user()->name }}</p>
                <p class="text-sm uppercase">{{ Auth::user()->type }}</p>
            </div> --}}
        </div>

        <!-- Menu -->
        <div class="px-3">
            <div class="shadow shadow-primary w-full rounded-lg mt-4 bg-gradient-to-b from-secondary to-primary ">
                <div class="w-full h-10 flex items-center rounded-lg text-white px-3.5">
                    <i class='bx bx-menu text-xl mb-0.5 mr-1'></i> MENU
                </div>
                <div class="w-full px-2 pb-2 rounded-lg space-y-2">
                    <a href="{{ route('member.dashboard', $keyname) }}"
                        class="h-10 flex items-center justify-start gap-2  rounded-md px-2 hover:bg-light transition-colors duration-500 {{ request()->routeIs('member.dashboard') ? 'bg-light' : 'bg-white' }}">
                        <i class='bx bxs-dashboard text-3xl'></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('member.profile.index', $keyname) }}"
                        class="h-10 flex items-center justify-start gap-2  rounded-md px-2 hover:bg-light transition-colors duration-500 {{ request()->routeIs('member.profile.*') ? 'bg-light' : 'bg-white' }}">
                        <i class='bx bxs-dashboard text-3xl'></i>
                        <span>Profile</span>
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
