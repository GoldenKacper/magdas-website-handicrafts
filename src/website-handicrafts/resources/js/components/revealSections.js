// resources/js/appScripts/home/revealSections.js
import $ from "jquery";
import { onceIntersection, prefersReducedMotion } from "../utils.js";
window.$ = window.jQuery = $;

// Generic reveal helper:
// - containerSelector: section ID or selector
// - itemSelector: elements inside that will be staggered (default .stagger-item)
// - addClass: class to add to container when revealed (default 'in-view')
// - useCssOrder: if true, set --order on items and rely on CSS calc delays
export function setupRevealSection({
    containerSelector,
    itemSelector = ".stagger-item",
    addClass = "in-view",
    ioOptions = { rootMargin: "0px 0px -100px 0px", threshold: 0 },
} = {}) {
    const container = document.querySelector(containerSelector);
    if (!container) return () => {};

    // do nothing if reduced motion preference
    // if (prefersReducedMotion()) {
    //     container.classList.add(addClass);
    //     if (!useCssOrder) {
    //         // fallback: add .show to children immediately
    //         const els = container.querySelectorAll(itemSelector);
    //         els.forEach((el) => el.classList.add("show"));
    //     }
    //     return () => {};
    // }

    const reveal = () => {
        // if not using CSS delay, add .show staggered by JS (but avoid large timeouts)
        const items = container.querySelectorAll(itemSelector);
        items.forEach((el, idx) => {
            setTimeout(() => el.classList.add("show"), 200 * idx);
        });

        container.classList.add(addClass);
    };

    // run once when enters viewport
    // This line triggers reveal exactly once when the container element appears in the viewport.
    onceIntersection(container, reveal, ioOptions);
    return () => {}; // no cleanup needed — onceIntersection disconnects
}
