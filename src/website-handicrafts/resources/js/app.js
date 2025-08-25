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

// import "bootstrap/dist/css/bootstrap.min.css"; // loading Bootstrap's CSS
import "../sass/app.scss";
import "bootstrap"; // loading Bootstrap's JS (popper required)
import "../images/magdas_website_logo_25_08_2025_demo.png";
import "../css/myStyles.css";
import "./myScripts.js";
