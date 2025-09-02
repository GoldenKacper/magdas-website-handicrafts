import $ from "jquery"; // explicit import
window.$ = window.jQuery = $; // (optinal) global expose

// Event to listen for scroll and resize events to update navbar state
$(function () {
    const $nav = $("nav.navbar.sticky-top");
    if (!$nav.length) return; // nothing to do if no navbar found

    const SCROLL_CLASS = "scrolled";
    let ticking = false;

    function updateNavbarState() {
        const scrollY =
            window.pageYOffset || document.documentElement.scrollTop || 0;
        if (scrollY > 0) {
            $nav.addClass(SCROLL_CLASS);
        } else {
            $nav.removeClass(SCROLL_CLASS);
        }
        ticking = false;
    }

    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(updateNavbarState);
            ticking = true;
        }
    }

    // first check on load (e.g., when a link jumps to the middle of the page)
    updateNavbarState();

    // listen for scroll events (throttled by RAF)
    $(window).on("scroll", requestTick);

    // optionally: also react to resize (e.g., when the browser bar changes height)
    $(window).on("resize", requestTick);
});
