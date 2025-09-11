import $ from "jquery";
window.$ = window.jQuery = $;

export default function initProductModalSlider(
    modalSelector = "#galleryProductModal",
    opts = {}
) {
    const cfg = { animMs: 420, swipeThreshold: 24, ...opts };

    // Initiate each time the modal is opened (the modal is pulled by AJAX)
    $(document).on("shown.bs.modal", modalSelector, function () {
        const $modal = $(this);
        const $viewport = $modal.find(".pg-viewport");
        const $track = $modal.find(".pg-track");
        let $slides = $track.children(".pg-item");
        const count = $slides.length;
        if (!count) return;

        // If already built, do not duplicate again
        if (!$track.data("pgBuilt")) {
            // clones at the ends = seamless looping
            const $first = $slides
                .first()
                .clone(true, true)
                .addClass("pg-clone");
            const $last = $slides.last().clone(true, true).addClass("pg-clone");
            $track.prepend($last);
            $track.append($first);
            $slides = $track.children(".pg-item");
            $track.data("pgBuilt", true);
        }

        // State
        let step = 0; // width of viewport (1 slide)
        let idx = 0; // index in original pool (0..count-1)

        function measure() {
            step = $viewport[0].clientWidth || 1;
            // each slide is 100% of the viewport thanks to flex:0 0 100% — we don't set width manually
        }

        function setTransform(tx, animate = true) {
            $track.css(
                "transition",
                animate ? `transform ${cfg.animMs}ms ease-in-out` : "none"
            );
            $track.css("transform", `translateX(${tx}px)`);
        }

        function gotoIndex(i, animate = true) {
            idx = ((i % count) + count) % count; // safe wrap
            setTransform(-((idx + 1) * step), animate); // +1 because at the beginning we have a left clone
            updateThumbs();
        }

        function normalizeAfter() {
            // after passing "through clone" jump without animation to the correct slide
            const tx = getTranslateX();
            const leftCloneTx = 0; // when idx = -1 (theoretically) we would be at 0px
            const rightCloneTx = -((count + 1) * step);
            if (Math.abs(tx - rightCloneTx) < 2) {
                // we were on the right clone => jump to 1st real
                setTransform(-step, false);
            } else if (Math.abs(tx - leftCloneTx) < 2) {
                // we were on the left clone => jump to last real
                setTransform(-(count * step), false);
            }
        }

        function getTranslateX() {
            const st = window.getComputedStyle($track[0]).transform;
            if (!st || st === "none") return 0;
            const m = st.match(/matrix\(([^)]+)\)/);
            if (!m) return 0;
            const parts = m[1].split(",");
            return parseFloat(parts[4]) || 0;
        }

        function next() {
            gotoIndex(idx + 1, true);
        }
        function prev() {
            gotoIndex(idx - 1, true);
        }

        function updateThumbs() {
            const $t = $modal.find(".pg-thumb");
            $t.removeClass("active");
            $t.eq(idx).addClass("active");
        }

        // Initialization
        measure();
        // show first real (after left clone)
        setTransform(-step, false);
        idx = 0;
        updateThumbs();

        // Events
        $track
            .off(".pg")
            .on("transitionend.pg webkitTransitionEnd.pg", function () {
                normalizeAfter();
            });

        $modal
            .find(".pg-next")
            .off("click.pg")
            .on("click.pg", function (e) {
                e.preventDefault();
                next();
            });
        $modal
            .find(".pg-prev")
            .off("click.pg")
            .on("click.pg", function (e) {
                e.preventDefault();
                prev();
            });

        $modal
            .find(".pg-thumb")
            .off("click.pg")
            .on("click.pg", function (e) {
                e.preventDefault();
                const i = parseInt($(this).data("idx"), 10) || 0;
                gotoIndex(i, true);
            });

        // Keyboard
        $modal.off("keydown.pg").on("keydown.pg", function (e) {
            if (e.key === "ArrowRight") {
                e.preventDefault();
                next();
            } else if (e.key === "ArrowLeft") {
                e.preventDefault();
                prev();
            }
        });

        // Swipe (phone/tablet)
        (function attachSwipe() {
            let sx = 0,
                sy = 0,
                moved = false,
                blocked = false;

            function onStart(ev) {
                const t = ev.touches ? ev.touches[0] : ev;
                sx = t.clientX;
                sy = t.clientY;
                moved = false;
                blocked = false;
            }
            function onMove(ev) {
                const t = ev.touches ? ev.touches[0] : ev;
                const dx = t.clientX - sx,
                    dy = t.clientY - sy;
                if (
                    Math.abs(dx) > Math.abs(dy) &&
                    Math.abs(dx) > cfg.swipeThreshold
                ) {
                    if (ev.cancelable) ev.preventDefault();
                    blocked = true;
                    moved = true;
                }
            }
            function onEnd(ev) {
                if (!blocked) return;
                const t = ev.changedTouches ? ev.changedTouches[0] : null;
                if (!t) return;
                const dx = t.clientX - sx;
                if (dx < -cfg.swipeThreshold) next();
                else if (dx > cfg.swipeThreshold) prev();
            }

            const el = $viewport[0];
            el.addEventListener("touchstart", onStart, { passive: true });
            el.addEventListener("touchmove", onMove, { passive: false });
            el.addEventListener("touchend", onEnd, { passive: true });
        })();

        // Reaction to window resize
        $(window)
            .off("resize.pg")
            .on("resize.pg", function () {
                const current = idx;
                measure();
                gotoIndex(current, false);
            });

        // Clear after closing the modal
        $modal.one("hidden.bs.modal", function () {
            $(window).off("resize.pg");
            $modal.off(".pg");
            $track.off(".pg");
        });
    });
}
