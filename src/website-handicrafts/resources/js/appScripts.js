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

//
// ------------- Footer section -------------
//
function isElementInViewportApp(el, offset = 0) {
    const rect = el.getBoundingClientRect();
    return (
        rect.top <=
            (window.innerHeight || document.documentElement.clientHeight) -
                offset && rect.bottom >= 0 + offset
    );
}

// Footer animation
function revealFooter() {
    const $section = $("footer");
    if (!$section.length) return;

    // if already triggered, do nothing
    if ($section.hasClass("in-view")) return;

    if (isElementInViewportApp($section[0], 100)) {
        $section.addClass("in-view");

        // fade-in title/subtitle done by CSS. Stagger cards using JS:
        const $cards = $section.find(
            ".footer-scroll-animation-1, .footer-scroll-animation-2, .footer-scroll-animation-3"
        );

        $cards.each(function (i, el) {
            setTimeout(function () {
                $(el).addClass("show");
            }, 200 * i + 0); // 300ms, 600ms, 900ms, ...
        });
    }
}

// init on load and scroll (debounce small)
let footerTimer = null;
$(window).on("load scroll resize", function () {
    if (footerTimer) clearTimeout(footerTimer);
    footerTimer = setTimeout(revealFooter, 60);
});

// also run once immediately
$(document).ready(function () {
    revealFooter();
});
