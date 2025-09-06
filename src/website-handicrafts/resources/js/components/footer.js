import $ from "jquery";
import { isElementInViewport } from "../utils.js";
window.$ = window.jQuery = $;

// opts: selector for footer and item selector and rootMargin/threshold for IO
export default function initFooter(opts = {}) {
    const {
        footerSelector = "footer",
        itemSelector = ".footer-scroll-animation",
        rootMargin = "0px 0px -100px 0px",
        threshold = 0,
    } = opts;

    const $footer = $(footerSelector);
    if (!$footer.length) return () => {};

    const elFooter = $footer.get(0); // get raw DOM element
    const $items = $footer.find(itemSelector);

    // reveal handler (adds in-view and show class)
    function reveal() {
        $footer.addClass("in-view");
        $items.each((i, el) =>
            setTimeout(() => $(el).addClass("show"), 200 * i)
        );
    }

    // intersection observer if available
    let io;
    if ("IntersectionObserver" in window) {
        io = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        reveal();
                        if (io) {
                            io.unobserve(elFooter);
                            io.disconnect();
                        }
                    }
                });
            },
            { root: null, rootMargin, threshold }
        );

        io.observe(elFooter);
    } else {
        // fallback - basic check on load/scroll/resize
        const onCheck = () => {
            if (isElementInViewport(elFooter, 60)) {
                reveal();
                $(window).off(
                    "load.footer check.footer scroll.footer resize.footer"
                );
            }
        };
        $(window).on("load.footer scroll.footer resize.footer", onCheck);
        // run immediately
        onCheck();
    }

    // cleanup
    return function destroy() {
        if (io) {
            io.unobserve(elFooter);
            io.disconnect();
        }
        $(window).off("load.footer scroll.footer resize.footer");
    };
}
