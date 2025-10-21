// Toggle Sidebar
$(document).ready(function () {
    if ($('#profile_dropdown_btn')) {
        const $button = $('#profile_dropdown_btn');
        const $menu = $('#profile-dropdown-menu');
        $button.on('click', function (e) {
            e.stopPropagation();
            $menu.toggleClass('hidden');
        });
        $(document).on('click', function (e) {
            if (!$button.is(e.target) && $button.has(e.target).length === 0 &&
                !$menu.is(e.target) && $menu.has(e.target).length === 0) {
                if (!$menu.hasClass('hidden')) {
                    $menu.addClass('hidden');
                }
            }
        });
    }

    if ($('#mainHeader')) {
        const header = $('#mainHeader');
        const scrollTarget = $('#main-scroll-area');
        const scrollBoundary = 80;

        function handleScroll() {
            const currentScroll = scrollTarget.scrollTop();
            if (currentScroll > scrollBoundary) {
                header.removeClass('bg-transparent');
                header.addClass('bg-white/50 shadow-md');
            } else {
                header.removeClass('bg-white/50 shadow-md');
                header.addClass('bg-transparent');
            }
        }
        scrollTarget.scroll(handleScroll);
        handleScroll();
    }


});

// Modal
$(document).ready(function () {

    // --- FUNGSI UTAMA UNTUK MENUTUP MODAL ---
    function closeDialog(dialogId) {
        const backdrop = $(`div[data-modal-backdrop="${dialogId}"]`);
        const dialog = $(`div[data-dialog="${dialogId}"]`);

        // 1. Tambahkan kelas tersembunyi
        backdrop.removeClass('opacity-100 pointer-events-auto').addClass('opacity-0 pointer-events-none');

        // Opsional: Jika Anda ingin efek scale-down saat menutup, tambahkan kelas transisi di sini
        // dialog.removeClass('scale-100').addClass('scale-90'); 
    }

    // --- 1. Event BUKA MODAL ---
    // Mencari semua tombol yang memiliki data-modal-target
    $('[data-modal-target]').on('click', function () {
        const dialogId = $(this).data('modal-target');
        const backdrop = $(`div[data-modal-backdrop="${dialogId}"]`);
        const dialog = $(`div[data-dialog="${dialogId}"]`);

        // 2. Hapus kelas tersembunyi
        backdrop.removeClass('opacity-0 pointer-events-none').addClass('opacity-100 pointer-events-auto');

        // Opsional: Jika Anda ingin efek scale-up, tambahkan kelas transisi di sini
        // dialog.removeClass('scale-90').addClass('scale-100'); 

        // 3. Tambahkan dialogId ke elemen modal untuk penanganan penutupan (opsional, tapi membantu)
        backdrop.data('open-dialog-id', dialogId);
    });


    // --- 2. Event TUTUP MODAL (Klik Backdrop) ---
    // Mencari semua backdrop yang bisa ditutup dengan klik
    $('[data-modal-backdrop-close="true"]').on('click', function (e) {
        // Cek apakah yang diklik benar-benar backdrop (bukan konten di dalamnya)
        if ($(e.target).is(this)) {
            const dialogId = $(this).data('modal-backdrop');
            closeDialog(dialogId);
        }
    });

    // --- 3. Event TUTUP MODAL (Tombol ESC) ---
    $(document).on('keydown', function (e) {
        if (e.key === "Escape") {
            // Cari modal yang sedang aktif/terbuka (opacity-100)
            const openBackdrop = $('div[data-modal-backdrop].opacity-100');
            if (openBackdrop.length) {
                const dialogId = openBackdrop.data('modal-backdrop');
                closeDialog(dialogId);
            }
        }
    });

    // Catatan: Jika Anda memiliki tombol 'Tutup' di dalam konten modal,
    // tambahkan data-dismiss="dialogId" pada tombol tersebut dan
    // buat event listener baru untuk tombol tersebut.
    $('[data-dismiss]').on('click', function () {
        const dialogId = $(this).data('dismiss');
        closeDialog(dialogId);
    })
});



