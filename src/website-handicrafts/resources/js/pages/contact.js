import "../../sass/pages/contact.scss";

import $ from "jquery"; // explicit import
window.$ = window.jQuery = $; // (optinal) global expose

import initFAQ from "../components/faq.js";
import initContactForm from "../components/contactForm.js";

// Initialize home scripts on DOM ready
// This is the jQuery shorthand for “document ready.”
$(function () {
    // init FAQ behaviours (accordion)
    initFAQ("#faq");
    initContactForm("#contact-form");
});
