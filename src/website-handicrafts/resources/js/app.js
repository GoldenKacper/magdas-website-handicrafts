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
import "../images/magdas_website_logo_25_08_2025_demo.png";
import "../images/magdas_website_logo_25_08_2025_demo_v2.png";
import "../images/magdas_website_home_og_26_08_2025_demo.webp";
import "../images/magdas_website_home_bg_27_08_2025_demo.png";

// import "bootstrap/dist/css/bootstrap.min.css"; // loading Bootstrap's CSS
import "../sass/app.scss";
import "bootstrap"; // loading Bootstrap's JS (popper required)
import "../css/myStyles.css";
import "./myScripts.js";
