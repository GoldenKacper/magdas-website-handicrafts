import $ from "jquery"; // explicit import
window.$ = window.jQuery = $; // (optinal) global expose
// opinions reveal - requires jQuery available (you have it)

// Co robi:
// el.getBoundingClientRect() zwraca obiekt rect z polami: top, bottom, left, right, width, height.
// Te wartości są względem widocznego obszaru okna przeglądarki (viewport).
// rect.top — odległość górnej krawędzi elementu od góry viewportu (może być ujemna gdy element jest już powyżej widoku).
// rect.bottom — odległość dolnej krawędzi elementu od góry viewportu.
// (window.innerHeight || document.documentElement.clientHeight) — wysokość viewportu (fallback do document.documentElement.clientHeight gdy np. innerHeight nie istnieje).
//
// Warunek:
// - górna krawędź elementu (rect.top) znajduje się nie niżej niż dolna granica viewportu minus offset (czyli element nie jest kompletnie poza dołem viewportu z marginesem offset);
// - i dolna krawędź elementu (rect.bottom) znajduje się nie wyżej niż górna granica viewportu plus offset (czyli element nie jest kompletnie powyżej viewportu z marginesem offset).
//
// Inny sposób myślenia:
// Funkcja sprawdza czy jakakolwiek część elementu znajduje się w oknie przeglądarki — z tym, że offset pozwala "przesunąć" granice.
// Dodatnie offset wymaga, żeby element był bardziej wewnątrz widoku, a nie tylko "stykający się" z krawędzią.
function isElementInViewport(el, offset = 0) {
    const rect = el.getBoundingClientRect();
    return (
        rect.top <=
            (window.innerHeight || document.documentElement.clientHeight) -
                offset && rect.bottom >= 0 + offset
    );
}

function revealOpinions() {
    const $section = $("#opinions");
    if (!$section.length) return;

    // if already triggered, do nothing
    if ($section.hasClass("in-view")) return;

    if (isElementInViewport($section[0], 200)) {
        $section.addClass("in-view");

        // fade-in title/subtitle done by CSS. Stagger cards using JS:
        const $cards = $section.find(".opinion-card");
        $cards.each(function (i, el) {
            setTimeout(function () {
                $(el).addClass("show");
            }, 200 * i + 0); // 300ms, 600ms, 900ms, ...
        });
    }
}

// init on load and scroll (debounce small)
let opinionTimer = null;
$(window).on("load scroll resize", function () {
    if (opinionTimer) clearTimeout(opinionTimer);
    opinionTimer = setTimeout(revealOpinions, 60);
});

// also run once immediately
$(document).ready(function () {
    revealOpinions();
});
