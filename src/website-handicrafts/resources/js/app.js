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

// import "bootstrap/dist/css/bootstrap.min.css"; // loading Bootstrap's CSS
import "../sass/app.scss";
import "bootstrap"; // loading Bootstrap's JS (popper required)
import "../css/myStyles.css";
import "./myScripts.js";
