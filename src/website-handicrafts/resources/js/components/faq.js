// resources/js/appScripts/home/faq.js
import $ from "jquery";
import { rafThrottle } from "../utils.js";
window.$ = window.jQuery = $;

export default function initFAQ(selector = "#faq") {
    const $root = $(selector);
    if (!$root.length) return () => {};

    const $items = $root.find(".faq-item");
    const $questions = $root.find(".faq-question");

    // ensure structure: wrap answer inner and set aria
    $items.each(function () {
        const $it = $(this);
        const $btn = $it.find(".faq-question");
        const $ans = $it.find(".faq-answer");

        if ($ans.length && $ans.children(".faq-answer-inner").length === 0) {
            $ans.wrapInner('<div class="faq-answer-inner"></div>');
        }

        if ($btn.length && typeof $btn.attr("aria-expanded") === "undefined") {
            $btn.attr("aria-expanded", "false");
        }

        if ($btn.attr("aria-expanded") === "true") {
            $ans.removeAttr("hidden");
            $ans[0].style.height = $ans[0].scrollHeight + "px";
            $it.addClass("open");
            $ans.find(".faq-answer-inner").css({
                transform: "translateY(0)",
                opacity: 1,
            });
        } else {
            $ans.attr("hidden", "");
            $ans[0].style.height = null;
            $it.removeClass("open");
            $ans.find(".faq-answer-inner").css({
                transform: "translateY(-6px)",
                opacity: 0,
            });
        }
    });

    function animateOpen($ans, done) {
        const el = $ans[0];
        const $inner = $ans.find(".faq-answer-inner");

        $ans.removeAttr("hidden");
        el.style.boxSizing = "border-box";
        const target = el.scrollHeight;

        $inner.css({ transform: "translateY(-6px)", opacity: 0 });

        el.style.height = "0px";
        // force reflow
        // eslint-disable-next-line no-unused-expressions
        el.offsetHeight;

        requestAnimationFrame(() => {
            el.style.transition = "height 360ms cubic-bezier(0.2,0.9,0.2,1)";
            el.style.height = target + "px";
            setTimeout(() => {
                $inner.css({ transform: "translateY(0)", opacity: 1 });
            }, 30);

            const onEnd = (ev) => {
                if (ev.propertyName === "height") {
                    el.style.height = "auto";
                    el.style.transition = "";
                    el.removeEventListener("transitionend", onEnd);
                    if (typeof done === "function") done();
                }
            };
            el.addEventListener("transitionend", onEnd);
        });
    }

    function animateClose($ans, done) {
        const el = $ans[0];
        const $inner = $ans.find(".faq-answer-inner");

        if ($ans.attr("hidden")) {
            if (typeof done === "function") done();
            return;
        }

        $inner.css({ transform: "translateY(-6px)", opacity: 0 });

        setTimeout(() => {
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

                const onEnd = (ev) => {
                    if (ev.propertyName === "height") {
                        $ans.attr("hidden", "");
                        el.style.height = null;
                        el.style.transition = "";
                        $inner.css({
                            transform: "translateY(-6px)",
                            opacity: 0,
                        });
                        el.removeEventListener("transitionend", onEnd);
                        if (typeof done === "function") done();
                    }
                };
                el.addEventListener("transitionend", onEnd);
            });
        }, 90);
    }

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
            $btn.attr("aria-expanded", "false");
            $item.removeClass("open");
            animateClose($ans);
        } else {
            const anyOpen =
                $items.find('.faq-question[aria-expanded="true"]').length > 0;
            closeAll(idx);
            const doOpen = () => {
                $btn.attr("aria-expanded", "true");
                $item.addClass("open");
                animateOpen($ans);
            };
            if (anyOpen) {
                setTimeout(doOpen, 300);
            } else {
                doOpen();
            }
        }
    });

    // keyboard accessibility
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

    // Return destroy function if needed
    return function destroy() {
        $questions.off("click keydown");
    };
}
