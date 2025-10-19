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



