import $ from "jquery";
import { rafThrottle } from "../../utils.js";
window.$ = window.jQuery = $;

export default function initNavbar(selector = "nav.navbar.sticky-top") {
    const $nav = $(selector);
    if (!$nav.length) return () => {};

    const SCROLL_CLASS = "scrolled";

    function updateNavbarState() {
        const scrollY =
            window.pageYOffset || document.documentElement.scrollTop || 0;
        if (scrollY > 0) $nav.addClass(SCROLL_CLASS);
        else $nav.removeClass(SCROLL_CLASS);
    }

    const onScroll = rafThrottle(updateNavbarState);

    // initial state
    updateNavbarState();

    // bind events (namespaced so we can remove them)
    $(window).on("scroll.appNav resize.appNav", onScroll);

    // return cleanup function if needed
    return function destroy() {
        $(window).off("scroll.appNav resize.appNav", onScroll);
    };
}
