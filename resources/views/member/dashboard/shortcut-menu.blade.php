<div class="w-full bg-gradient-to-tr from-primary to-secondary rounded-2xl p-0.5">
    <h2 class="px-4.5 py-1 text-white">Shortcut Menu</h2>
    <div
        class="w-full h-full bg-white p-4 rounded-2xl flex flex-wrap items-center justify-start md:justify-start md:gap-2">
        @if (Auth::user()->hasRole(['superadmin', 'admin', 'dokter', 'operator']))
            <a href="{{ route('admin.dashboard') }}"
                class="w-[23%] md:w-20 aspect-square hover:bg-primary/10 rounded-xl p-1.5">
                <div class="w-full h-full flex flex-col items-center">
                    <div class="w-10 h-10 flex items-center justify-center rounded-md overflow-hidden shrink-0">
                        <img src="{{ asset('assets/svg/panel2.svg') }}" alt="" class="w-full h-full object-cover">
                    </div>
                    <div class="w-full h-[26px] text-[10px]/3 md:text-xs/3 flex items-end justify-center mt-0.5">
                        <p class="text-center capitalize text-primary">Admin Dashboard</p>
                    </div>
                </div>
            </a>
        @endif
        <a href="{{ route('member.profile.index', $keyname) }}"
            class="w-[23%] md:w-20 aspect-square hover:bg-primary/10 rounded-xl p-1.5">
            <div class="w-full h-full flex flex-col items-center">
                <div class="w-10 h-10 flex items-center justify-center rounded-md overflow-hidden shrink-0">
                    <img src="{{ asset('assets/svg/profile.svg') }}" alt="" class="w-full h-full object-cover">
                </div>
                <div class="w-full h-[26px] text-[10px]/3 md:text-xs/3 flex items-end justify-center mt-0.5">
                    <p class="text-center capitalize text-primary">Profile</p>
                </div>
            </div>
        </a>
        <a href="#" class="w-[23%] md:w-20 aspect-square hover:bg-primary/10 rounded-xl p-1.5">
            <div class="w-full h-full flex flex-col items-center">
                <div class="w-10 h-10 flex items-center justify-center rounded-md overflow-hidden shrink-0">
                    <img src="{{ asset('assets/svg/vaccine.svg') }}" alt="" class="w-full h-full object-cover">
                </div>
                <div class="w-full h-[26px] text-[10px]/3 md:text-xs/3 flex items-end justify-center mt-0.5">
                    <p class="text-center capitalize text-primary">Formulir Vaksin</p>
                </div>
            </div>
        </a>

    </div>
</div>
