    <div class="w-full h-full px-3 flex items-center justify-start lg:bg-white">
        <div class="w-8 h-8 rounded-md mr-3 flex items-center justify-center shadow hover:bg-primary/10">
            <a href="{{ $link }}" class=" flex items-center justify-center"><i
                    class='bx bx-left-arrow-alt text-3xl'></i></a>
        </div>
        <div>
            {{ $slot }}
        </div>
    </div>
