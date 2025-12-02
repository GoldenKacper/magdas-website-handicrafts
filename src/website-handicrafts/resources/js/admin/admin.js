import "../bootstrap"; // default setup (axios etc.)

import $ from "jquery";
window.$ = window.jQuery = $; // expose debug

import axios from "axios";
window.axios = axios;

// Required by Laravel for AJAX CSRF protection:
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
const token = document.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common["X-CSRF-TOKEN"] =
        token.getAttribute("content");
}

// static admin images
import "../../images/magdas_website_logo_25_09_2025.webp"; // Website logo - version 3
import "../../images/magdas_website_logo_25_09_2025_part_1.webp"; // Website logo - version 3 - part 1 Malin
import "../../images/magdas_website_logo_25_09_2025_part_2.webp"; // Website logo - version 3 - part 2 Raspberry
import "../../images/magdas_website_logo_25_09_2025_part_3.webp"; // Website logo - version 3 - part 3 Tagline
import "../../images/magdas_website_admin_auth_bg_02_12_2025.jpg"; // Admin Panel Auth Background

// import "bootstrap/dist/css/bootstrap.min.css"; // loading Bootstrap's CSS
import "../../sass/admin/admin.scss";
import "bootstrap"; // loading Bootstrap's JS (popper required)
import "../../css/admin/admin.css";

// DataTables (Bootstrap 5)
import DataTable from "datatables.net-bs5";
import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";
window.DataTable = DataTable;

// Admin modules
import initAdminNavbar from "./components/navbar.js";
import initFlashMessages from "./components/flashMessage.js";
// import initAdminSidebar from "./admin/components/sidebar";

$(function () {
    // inicjalizacja globalna admin
    const destroyAdminNavbar = initAdminNavbar("nav.navbar.sticky-top");
    const flashMessages = initFlashMessages(".flash-message");
    // const destroyAdminSidebar = initAdminSidebar();

    // expose for debugging
    window.__admin = {
        destroyAdminNavbar,
        flashMessages,
        // initAdminSidebar,
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
            // In admin panel some pages may not have specific JS module
            console.warn(`Page module ./pages/${page}.js not found`, err);
        });
}
