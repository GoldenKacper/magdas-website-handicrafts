import $ from "jquery"; // explicit import
window.$ = window.jQuery = $; // (optinal) global expose

// Function definition
function setBodyBlue() {
    $("body").css("background-color", "blue");
    console.log("setBodyBlue called");
}

// Call after DOM is loaded (jQuery)
$(function () {
    console.log("myScripts loaded");
    // perform test — set body background to blue
    setBodyBlue();
});
