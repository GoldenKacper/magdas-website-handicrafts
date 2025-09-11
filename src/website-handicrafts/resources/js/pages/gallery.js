import "../../sass/pages/gallery.scss";

import $ from "jquery"; // explicit import
window.$ = window.jQuery = $; // (optinal) global expose

import initGallery from "../components/gallery";
import initProductModalSlider from "../components/modalProductSlider";

// Initialize home scripts on DOM ready
// This is the jQuery shorthand for “document ready.”
$(function () {
    // Initialize gallery
    initGallery(".gallery-row", {
        autoplayInterval: 5000,
        animMs: 420,
        pauseOnHover: true,
        bufferExtra: 4,
    });

    // Slider support in modal
    initProductModalSlider("#galleryProductModal");
});
