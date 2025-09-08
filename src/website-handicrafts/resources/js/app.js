import "./bootstrap"; // default setup (axios etc.)

import $ from "jquery";
window.$ = window.jQuery = $; // expose global if needed for jQuery plugins

import axios from "axios";
window.axios = axios;

// Required by Laravel for AJAX CSRF protection:
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
const token = document.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common["X-CSRF-TOKEN"] =
        token.getAttribute("content");
}

// static Images
import "../images/magdas_website_logo_25_08_2025_demo.png"; // Website logo - version 1
import "../images/magdas_website_logo_25_08_2025_demo_v2.png"; // Website logo - version 2
import "../images/magdas_website_home_og_26_08_2025_demo.webp"; // Website logo - open graph / twitter (meta)
import "../images/magdas_website_home_bg_27_08_2025_demo.png"; // Home Hero background image
import "../images/magdas_website_offer_bracelet_31_08_2025_demo.png"; // Offer 1
import "../images/magdas_website_offer_earrings_31_08_2025_demo.png"; // Offer 2
import "../images/magdas_website_offer_necklace_31_08_2025_demo.png"; // Offer 3
import "../images/magdas_website_home_about_me_bg_01_09_2025_demo.png"; // Home About Me - Backgorund
import "../images/magdas_website_home_about_me_bg_01_09_2025_demo_v2.webp"; // Home About Me - Upgraded Backgorund
import "../images/magdas_website_home_about_me_author_01_09_2025_demo.png"; // Home About Me - Author
import "../images/magdas_website_home_1_opinion_02_09_2025.png"; // Home Opinion - 1
import "../images/magdas_website_home_2_opinion_02_09_2025_demo.png"; // Home Opinion - 2
import "../images/magdas_website_home_3_opinion_02_09_2025_demo.jpg"; // Home Opinion - 3
import "../images/magdas_website_home_4_opinion_02_09_2025_demo.jpg"; // Home Opinion - 4
import "../images/magdas_website_faq_bg_02_09_2025_demo.webp"; // Home FAQ
import "../images/magdas_website_faq_bg_02_09_2025_demo_v2.webp"; // Home FAQ v2

// import "bootstrap/dist/css/bootstrap.min.css"; // loading Bootstrap's CSS
import "../sass/app.scss";
import "bootstrap"; // loading Bootstrap's JS (popper required)
import "../css/appStyles.css";

import initNavbar from "./components/navbar.js";
import initFooter from "./components/footer.js";

// Initialize modules
$(function () {
    const destroyNavbar = initNavbar("nav.navbar.sticky-top");
    const destroyFooter = initFooter({
        footerSelector: "footer",
        itemSelector: ".footer-scroll-animation",
        rootMargin: "0px 0px -100px 0px",
        threshold: 0,
    });

    // expose for debug (optional)
    window.__appScripts = {
        destroyNavbar,
        destroyFooter,
    };
}); // jQuery DOM ready

// detect page — możesz użyć data-attribute na <body> lub classu lub meta tagu
const page =
    document.body.dataset.page ||
    document.documentElement.getAttribute("data-page");

if (page) {
    // dynamic import (vite will code-split)
    import(`./pages/${page}.js`)
        .then((module) => {
            // if module default export is a function, call it
            if (module && typeof module.default === "function") {
                module.default();
            }
        })
        .catch((err) => {
            // optional: handle missing module quietly (non-critical)
            console.error(`Page module ./pages/${page}.js not found`, err);
        });
}
