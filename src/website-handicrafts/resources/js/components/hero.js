import $ from "jquery";
import {
    onceIntersection,
    rafThrottle,
    prefersReducedMotion,
} from "../utils.js";
window.$ = window.jQuery = $;

export default function initHero(opts = {}) {
    const selector = opts.selector || ".hero";
    const threshold = opts.threshold ?? 0.12;
    const rootMargin = opts.rootMargin || "0px 0px -8% 0px";
    const HIDE_CLASS = opts.hideClass || "hero-fixed-hidden";

    const el = document.querySelector(selector);
    if (!el) return () => {};

    // If mobile fallback class present, do nothing.
    if (el.classList.contains("hero-scroll")) return () => {};

    // Use IO if available (preferred)
    if ("IntersectionObserver" in window) {
        const io = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.intersectionRatio > threshold) {
                        el.classList.remove(HIDE_CLASS);
                        el.setAttribute("data-hero-bg-hidden", "false");
                    } else {
                        el.classList.add(HIDE_CLASS);
                        el.setAttribute("data-hero-bg-hidden", "true");
                    }
                });
            },
            { root: null, threshold: [0, threshold, 0.5, 1], rootMargin }
        );

        io.observe(el);
        return function destroy() {
            io.unobserve(el);
            io.disconnect();
        };
    }

    // fallback: rAF scroll check
    let ticking = false;
    function check() {
        ticking = false;
        const rect = el.getBoundingClientRect();
        const vh = window.innerHeight || document.documentElement.clientHeight;
        const visibleTop = Math.max(
            0,
            Math.min(rect.bottom, vh) - Math.max(rect.top, 0)
        );
        const ratio = visibleTop / Math.max(1, rect.height);
        if (ratio > threshold) {
            el.classList.remove(HIDE_CLASS);
            el.setAttribute("data-hero-bg-hidden", "false");
        } else {
            el.classList.add(HIDE_CLASS);
            el.setAttribute("data-hero-bg-hidden", "true");
        }
    }

    const onScroll = rafThrottle(check);
    window.addEventListener("scroll", onScroll, { passive: true });
    window.addEventListener("resize", onScroll, { passive: true });

    // initial
    requestAnimationFrame(check);

    return function destroy() {
        window.removeEventListener("scroll", onScroll);
        window.removeEventListener("resize", onScroll);
    };
}
