import $ from "jquery"; // explicit import
window.$ = window.jQuery = $; // (optinal) global expose
// opinions reveal - requires jQuery available (you have it)

//
// ------------- Opinions section -------------
//
// What it does:
// el.getBoundingClientRect() returns a rect object with the following fields: top, bottom, left, right, width, height.
// These values are relative to the visible area of the browser window (viewport).
// rect.top — the distance between the top edge of the element and the top of the viewport (can be negative if the element is already above the view).
// rect.bottom — the distance between the bottom edge of the element and the top of the viewport.
// (window.innerHeight || document.documentElement.clientHeight) — height of the viewport (fallback to document.documentElement.clientHeight when, for example, innerHeight does not exist).
//
// Condition:
// - the top edge of the element (rect.top) is not lower than the bottom edge of the viewport minus the offset (i.e., the element is not completely outside the bottom of the viewport with the offset margin);
// - and the bottom edge of the element (rect.bottom) is no higher than the top of the viewport plus the offset (i.e., the element is not completely above the viewport with the offset margin).
//
// Another way of thinking:
// The function checks whether any part of the element is within the browser window — except that the offset allows the boundaries to be "moved".
// A positive offset requires the element to be more inside the view, not just "touching" the edge.
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

//
// ------------- FAQ section -------------
//
function revealFaq() {
    const $section = $("#faq");
    if (!$section.length) return;

    // if already triggered, do nothing
    if ($section.hasClass("in-view")) return;

    if (isElementInViewport($section[0], 200)) {
        $section.addClass("in-view");

        // fade-in title/subtitle done by CSS. Stagger cards using JS:
        const $cards = $section.find(".faq-item");
        $cards.each(function (i, el) {
            setTimeout(function () {
                $(el).addClass("show");
            }, 200 * i + 0); // 300ms, 600ms, 900ms, ...
        });
    }
}

let faqTimer = null;
$(window).on("load scroll resize", function () {
    if (faqTimer) clearTimeout(faqTimer);
    faqTimer = setTimeout(revealFaq, 60);
});

// also run once immediately
$(document).ready(function () {
    revealFaq();
});

// FAQ: improved open/close animation + IntersectionObserver to reveal titles
// $(function () {
//     const $faq = $("#faq");
//     if (!$faq.length) return;

//     const $items = $faq.find(".faq-item");
//     const $questions = $faq.find(".faq-question");

//     // INIT: ensure aria & hidden state consistent
//     $items.each(function () {
//         const $item = $(this);
//         const $btn = $item.find(".faq-question");
//         const $answer = $item.find(".faq-answer");

//         if ($btn.length && $answer.length) {
//             if (typeof $btn.attr("aria-expanded") === "undefined") {
//                 $btn.attr("aria-expanded", "false");
//             }

//             if ($btn.attr("aria-expanded") === "true") {
//                 // open by default
//                 $answer.removeAttr("hidden");
//                 $answer[0].style.height = $answer[0].scrollHeight + "px";
//                 $item.addClass("open");
//             } else {
//                 $answer.attr("hidden", "");
//                 $answer[0].style.height = null;
//                 $item.removeClass("open");
//             }
//         }
//     });

//     function animateOpen($ans, doneCb) {
//         const el = $ans[0];
//         // remove hidden so we can measure
//         $ans.removeAttr("hidden");

//         // ensure box-sizing border-box
//         el.style.boxSizing = "border-box";

//         // set current height from computed if needed
//         const prevHeight = el.getBoundingClientRect().height;

//         // measure target height (scrollHeight)
//         const target = el.scrollHeight;

//         // start from 0 or current height
//         el.style.height = prevHeight + "px";
//         el.style.opacity = "0";
//         el.style.transform = "translateY(-6px)";

//         // force layout so browser applies the start state
//         // eslint-disable-next-line no-unused-expressions
//         el.offsetHeight;

//         // then schedule change to target inside rAF
//         requestAnimationFrame(() => {
//             el.style.transition =
//                 "height 360ms cubic-bezier(0.2,0.9,0.2,1), opacity 280ms ease, transform 280ms ease";
//             el.style.height = target + "px";
//             el.style.opacity = "1";
//             el.style.transform = "translateY(0)";

//             const onEnd = (ev) => {
//                 if (ev.propertyName === "height") {
//                     // after animation set height to auto for natural growth
//                     el.style.height = "auto";
//                     el.style.transition = "";
//                     el.removeEventListener("transitionend", onEnd);
//                     if (typeof doneCb === "function") doneCb();
//                 }
//             };
//             el.addEventListener("transitionend", onEnd);
//         });
//     }

//     function animateClose($ans, doneCb) {
//         const el = $ans[0];

//         // If already hidden or height 0, skip
//         if ($ans.attr("hidden")) {
//             if (typeof doneCb === "function") doneCb();
//             return;
//         }
//         // measure current height
//         const current = el.getBoundingClientRect().height;

//         // set explicit height (ensure we animate from a real pixel value)
//         el.style.height = current + "px";
//         el.style.boxSizing = "border-box";
//         // force reflow
//         // eslint-disable-next-line no-unused-expressions
//         el.offsetHeight;

//         // now trigger closing transition in next rAF to avoid jump
//         requestAnimationFrame(() => {
//             el.style.transition =
//                 "height 360ms cubic-bezier(0.2,0.9,0.2,1), opacity 280ms ease, transform 280ms ease";
//             el.style.height = "0px";
//             el.style.opacity = "0";
//             el.style.transform = "translateY(-6px)";

//             const onEnd = (ev) => {
//                 if (ev.propertyName === "height") {
//                     // hide element and clear inline styles
//                     $ans.attr("hidden", "");
//                     el.style.height = null;
//                     el.style.transition = "";
//                     el.style.opacity = null;
//                     el.style.transform = null;
//                     el.removeEventListener("transitionend", onEnd);
//                     if (typeof doneCb === "function") doneCb();
//                 }
//             };
//             el.addEventListener("transitionend", onEnd);
//         });
//     }

//     //     // animate open (height technique)
//     //     // function animateOpen($ans) {
//     //     //     const el = $ans[0];
//     //     //     // remove hidden so element occupies layout
//     //     //     $ans.removeAttr("hidden");
//     //     //     // ensure it's visible for measurement
//     //     //     el.style.display = "block";
//     //     //     // start from 0 height (if not already)
//     //     //     el.style.height = "0px";
//     //     //     // force reflow
//     //     //     void el.offsetHeight;
//     //     //     // target height
//     //     //     const target = el.scrollHeight + "px";
//     //     //     // apply transition (CSS also has it, but ensure it's present)
//     //     //     el.style.transition =
//     //     //         "height 320ms ease, opacity 320ms ease, transform 320ms ease";
//     //     //     el.style.height = target;
//     //     //     el.style.opacity = "1";
//     //     //     el.style.transform = "translateY(0)";

//     //     //     // after transition, set height to auto so content can grow naturally
//     //     //     const onEnd = function (ev) {
//     //     //         if (ev.propertyName === "height") {
//     //     //             el.style.height = "auto";
//     //     //             el.removeEventListener("transitionend", onEnd);
//     //     //         }
//     //     //     };
//     //     //     el.addEventListener("transitionend", onEnd);
//     //     // }

//     //     // // animate close
//     //     // function animateClose($ans) {
//     //     //     const el = $ans[0];
//     //     //     // if already hidden, do nothing
//     //     //     if ($ans.attr("hidden")) return;

//     //     //     // set explicit current height
//     //     //     el.style.height = el.scrollHeight + "px";
//     //     //     // force reflow
//     //     //     void el.offsetHeight;
//     //     //     // transition to zero
//     //     //     el.style.transition =
//     //     //         "height 320ms ease, opacity 320ms ease, transform 320ms ease";
//     //     //     el.style.height = "0px";
//     //     //     el.style.opacity = "0";
//     //     //     el.style.transform = "translateY(-6px)";

//     //     //     const onEnd = function (ev) {
//     //     //         if (ev.propertyName === "height") {
//     //     //             // hide after transition
//     //     //             $ans.attr("hidden", "");
//     //     //             // clear inline styles set by script
//     //     //             el.style.height = null;
//     //     //             el.style.opacity = null;
//     //     //             el.style.transform = null;
//     //     //             el.removeEventListener("transitionend", onEnd);
//     //     //         }
//     //     //     };
//     //     //     el.addEventListener("transitionend", onEnd);
//     //     // }

//     // close all except (pass index to keep open)
//     function closeAll(exceptIndex = -1) {
//         $items.each(function (i, el) {
//             if (i === exceptIndex) return;
//             const $it = $(el);
//             const $btn = $it.find(".faq-question");
//             const $ans = $it.find(".faq-answer");
//             $btn.attr("aria-expanded", "false");
//             $it.removeClass("open");
//             // animate close
//             animateClose($ans);
//         });
//     }

//     // click handler
//     $questions.on("click", function (e) {
//         const $btn = $(this);
//         const $item = $btn.closest(".faq-item");
//         const idx = $items.index($item);
//         const expanded = $btn.attr("aria-expanded") === "true";

//         if (expanded) {
//             // close it
//             $btn.attr("aria-expanded", "false");
//             $item.removeClass("open");
//             const $ans = $item.find(".faq-answer");
//             animateClose($ans);
//         } else {
//             // open this and close others
//             closeAll(idx);
//             $btn.attr("aria-expanded", "true");
//             $item.addClass("open");
//             const $ans = $item.find(".faq-answer");
//             animateOpen($ans);

//             // scroll into view on small screens for better UX
//             if (window.innerWidth < 768) {
//                 setTimeout(() => {
//                     $item[0].scrollIntoView({
//                         behavior: "smooth",
//                         block: "center",
//                     });
//                 }, 360);
//             }
//         }
//     });

//     // keyboard support
//     $questions.on("keydown", function (e) {
//         const $btn = $(this);
//         const $item = $btn.closest(".faq-item");
//         const idx = $items.index($item);

//         if (e.key === "Enter" || e.key === " ") {
//             e.preventDefault();
//             $btn.trigger("click");
//         } else if (e.key === "ArrowDown") {
//             e.preventDefault();
//             const next = (idx + 1) % $questions.length;
//             $questions.eq(next).focus();
//         } else if (e.key === "ArrowUp") {
//             e.preventDefault();
//             const prev = (idx - 1 + $questions.length) % $questions.length;
//             $questions.eq(prev).focus();
//         }
//     });
// });

$(function () {
    // prosty znacznik opóźnienia
    const OPEN_DELAY_MS = 300; // opóźnienie 0.3s

    const $faq = $("#faq");
    if (!$faq.length) return;

    const $items = $faq.find(".faq-item");
    const $questions = $faq.find(".faq-question");

    // --- INIT: wrap answers in .faq-answer-inner if not present, sync aria/hidden ---
    $items.each(function () {
        const $item = $(this);
        const $btn = $item.find(".faq-question");
        const $answer = $item.find(".faq-answer");

        // jeśli nie ma wrappera -> utwórz
        if (
            $answer.length &&
            $answer.children(".faq-answer-inner").length === 0
        ) {
            $answer.wrapInner('<div class="faq-answer-inner"></div>');
        }

        // ensure aria-expanded exists
        if ($btn.length && typeof $btn.attr("aria-expanded") === "undefined") {
            $btn.attr("aria-expanded", "false");
        }

        // set initial visible/hidden state
        if ($btn.attr("aria-expanded") === "true") {
            $answer.removeAttr("hidden");
            // ustaw height na scrollHeight aby był open
            $answer[0].style.height = $answer[0].scrollHeight + "px";
            $item.addClass("open");
            // ensure inner visible
            $answer
                .find(".faq-answer-inner")
                .css({ transform: "translateY(0)", opacity: 1 });
        } else {
            $answer.attr("hidden", "");
            $answer[0].style.height = null;
            $item.removeClass("open");
            // ensure inner hidden
            $answer
                .find(".faq-answer-inner")
                .css({ transform: "translateY(-6px)", opacity: 0 });
        }
    });

    // helper: open animation sequence - inner then outer
    function animateOpen($ans, doneCb) {
        const el = $ans[0];
        const $inner = $ans.find(".faq-answer-inner");
        // remove hidden so element is measurable
        $ans.removeAttr("hidden");
        // ensure box-sizing
        el.style.boxSizing = "border-box";
        // measure target
        const target = el.scrollHeight;

        // start: ensure inner hidden state (so animation goes inner->visible)
        $inner.css({ transform: "translateY(-6px)", opacity: 0 });

        // schedule height change + inner animation in rAF for smoothness
        // set explicit height to current (0 or computed) to get deterministic transition
        el.style.height = "0px";
        // force reflow
        // eslint-disable-next-line no-unused-expressions
        el.offsetHeight;

        requestAnimationFrame(() => {
            // start outer height transition
            el.style.transition = "height 360ms cubic-bezier(0.2,0.9,0.2,1)";
            el.style.height = target + "px";

            // animate inner slightly delayed so it appears nicely
            setTimeout(() => {
                $inner.css({ transform: "translateY(0)", opacity: 1 });
            }, 30); // małe opóźnienie, możesz dopasować

            // when height transition ends -> set height auto
            const onEnd = function (ev) {
                if (ev.propertyName === "height") {
                    el.style.height = "auto";
                    el.style.transition = "";
                    el.removeEventListener("transitionend", onEnd);
                    if (typeof doneCb === "function") doneCb();
                }
            };
            el.addEventListener("transitionend", onEnd);
        });
    }

    // helper: close sequence - first inner (visual), then outer height
    function animateClose($ans, doneCb) {
        const el = $ans[0];
        const $inner = $ans.find(".faq-answer-inner");

        // if already hidden -> done
        if ($ans.attr("hidden")) {
            if (typeof doneCb === "function") doneCb();
            return;
        }

        // 1) animate inner (fast) to disappear visually
        $inner.css({ transform: "translateY(-6px)", opacity: 0 });

        // 2) after a small delay start collapsing outer height
        setTimeout(() => {
            // measure current height (in case it was auto)
            const current = el.getBoundingClientRect().height;
            el.style.height = current + "px";
            el.style.boxSizing = "border-box";
            // force reflow
            // eslint-disable-next-line no-unused-expressions
            el.offsetHeight;

            requestAnimationFrame(() => {
                el.style.transition =
                    "height 360ms cubic-bezier(0.2,0.9,0.2,1)";
                el.style.height = "0px";

                const onEnd = function (ev) {
                    if (ev.propertyName === "height") {
                        // hide after transition and clear inline styles
                        $ans.attr("hidden", "");
                        el.style.height = null;
                        el.style.transition = "";
                        // ensure inner reset
                        $inner.css({
                            transform: "translateY(-6px)",
                            opacity: 0,
                        });
                        el.removeEventListener("transitionend", onEnd);
                        if (typeof doneCb === "function") doneCb();
                    }
                };
                el.addEventListener("transitionend", onEnd);
            });
        }, 90); // delay 90ms -> dajemy czas na płynne zanikanie inner
    }

    // close all except index (keep closed state consistent)
    function closeAll(exceptIndex = -1) {
        $items.each(function (i, el) {
            if (i === exceptIndex) return;
            const $it = $(el);
            const $btn = $it.find(".faq-question");
            const $ans = $it.find(".faq-answer");
            $btn.attr("aria-expanded", "false");
            $it.removeClass("open");
            animateClose($ans);
        });
    }

    // click handler
    $questions.on("click", function (e) {
        const $btn = $(this);
        const $item = $btn.closest(".faq-item");
        const idx = $items.index($item);
        const expanded = $btn.attr("aria-expanded") === "true";
        const $ans = $item.find(".faq-answer");

        if (expanded) {
            // close it
            $btn.attr("aria-expanded", "false");
            $item.removeClass("open");
            animateClose($ans);
        } else {
            // Sprawdź czy którykolwiek jest open
            const isAnyItemOpen = () =>
                $items.find('.faq-question[aria-expanded="true"]').length > 0;
            console.log(isAnyItemOpen());

            // open this and close others
            closeAll(idx);

            // funkcja otwierająca właściwie
            const doOpen = () => {
                $btn.attr("aria-expanded", "true");
                $item.addClass("open");
                animateOpen($ans);
                // if (window.innerWidth < 768) {
                //     setTimeout(
                //         () =>
                //             $item[0].scrollIntoView({
                //                 behavior: "smooth",
                //                 block: "center",
                //             }),
                //         420
                //     );
                // }
            };

            // jeśli przed chwilą wykonywaliśmy zamknięcie -> odczekaj OPEN_DELAY_MS
            if (isAnyItemOpen()) {
                setTimeout(doOpen, OPEN_DELAY_MS);
            } else {
                doOpen();
            }
        }
    });

    // keyboard support (Enter/Space + arrows)
    $questions.on("keydown", function (e) {
        const $btn = $(this);
        const $item = $btn.closest(".faq-item");
        const idx = $items.index($item);

        if (e.key === "Enter" || e.key === " ") {
            e.preventDefault();
            $btn.trigger("click");
        } else if (e.key === "ArrowDown") {
            e.preventDefault();
            const next = (idx + 1) % $questions.length;
            $questions.eq(next).focus();
        } else if (e.key === "ArrowUp") {
            e.preventDefault();
            const prev = (idx - 1 + $questions.length) % $questions.length;
            $questions.eq(prev).focus();
        }
    });
});
