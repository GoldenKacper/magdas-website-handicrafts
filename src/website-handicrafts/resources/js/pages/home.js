import "../../sass/pages/home.scss";

import $ from "jquery"; // explicit import
window.$ = window.jQuery = $; // (optinal) global expose

import initHero from "../components/hero.js";
import { setupRevealSection } from "../components/revealSections.js";
import initFAQ from "../components/faq.js";

// Initialize home scripts on DOM ready
// This is the jQuery shorthand for “document ready.”
$(function () {
    // Hero visibility
    initHero({
        selector: ".hero",
        threshold: 0.12,
        rootMargin: "0px 0px -8% 0px",
    });

    // About reveal (use .stagger-item inside #about)
    setupRevealSection({
        containerSelector: "#about",
        itemSelector: ".stagger-item", // I am not using a stagger in this section, so I have provided the default selector (no such class is used in this section).
        ioOptions: { rootMargin: "0px 0px -200px 0px" },
    });

    // Opinions
    setupRevealSection({
        containerSelector: "#opinions",
        itemSelector: ".opinion-card",
        ioOptions: { rootMargin: "0px 0px -200px 0px" },
    });

    // FAQ reveal for titles (not opening answers)
    setupRevealSection({
        containerSelector: "#faq",
        itemSelector: ".faq-item",
        ioOptions: { rootMargin: "0px 0px -200px 0px" },
    });

    // init FAQ behaviours (accordion)
    initFAQ("#faq");
});
