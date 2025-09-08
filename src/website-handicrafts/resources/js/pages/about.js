import "../../sass/pages/about.scss";

import $ from "jquery"; // explicit import
window.$ = window.jQuery = $; // (optinal) global expose

import { setupRevealSection } from "../components/revealSections.js";

// Initialize home scripts on DOM ready
// This is the jQuery shorthand for “document ready.”
$(function () {
    // About reveal (use .stagger-item inside #about)
    // setupRevealSection({
    //     containerSelector: "#about",
    //     itemSelector: ".stagger-item", // I am not using a stagger in this section, so I have provided the default selector (no such class is used in this section).
    //     ioOptions: { rootMargin: "0px 0px -200px 0px" },
    // });
});
