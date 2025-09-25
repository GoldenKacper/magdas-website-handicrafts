import $ from "jquery";
window.$ = window.jQuery = $;

import axios from "axios";
import { Modal } from "bootstrap";

import { throttleLeading, unlockBodyScroll, t } from "../utils";

export default function initGallery(selector = ".gallery-row", opts = {}) {
    const defaults = {
        autoplayInterval: 5000,
        animMs: 420,
        pauseOnHover: true,
        bufferExtra: 1, // additional storage space out of sight
        swipeThreshold: 28, // px
    };
    const settings = { ...defaults, ...opts };

    $(selector).each(function () {
        const $row = $(this);
        if ($row.data("__galleryInited")) return;
        $row.data("__galleryInited", true);

        const $viewport = $row.find(".gallery-viewport").first();
        const $strip = $row.find(".gallery-strip").first();
        const $track = $row.find(".gallery-track, [data-track]").first();
        if (!$viewport.length || !$strip.length || !$track.length) return;

        const $original = $track.children(".gallery-item").clone(true, true);
        const originalCount = $original.length;
        if (!originalCount) return;

        // State
        let $items = $();
        let visible = 6;
        let buffer = 0;
        let itemW = 0;
        let gap = 0;
        let step = 0;
        let index = 0; // current left index (in the entire sequence with buffers)
        let animating = false;
        let timer = null;
        let isHover = false;
        let isFocusWithin = false;

        // ---- Helper: geometry / CSS ----
        function readTilesVisible() {
            const css = getComputedStyle($strip[0])
                .getPropertyValue("--tiles-visible")
                .trim();
            let v = parseInt(css, 10);
            if (!Number.isFinite(v) || v <= 0) {
                if ($items.length < 1) return 1;
                const vw = $viewport[0].clientWidth;
                const r = $items[0].getBoundingClientRect();
                const w = r.width || 1;
                const g = readGapPx();
                v = Math.max(1, Math.round((vw + g) / (w + g)));
            }
            return v;
        }

        function readGapPx() {
            const style = getComputedStyle($track[0]);
            let g = parseFloat(style.gap || style.columnGap || "0") || 0;
            if ($items.length >= 2) {
                const r1 = $items[0].getBoundingClientRect();
                const r2 = $items[1].getBoundingClientRect();
                const diff = r2.left - r1.right;
                if (Number.isFinite(diff) && Math.abs(diff - g) > 0.5)
                    g = Math.max(0, diff);
            }
            return g;
        }

        function measure() {
            if ($items.length) {
                const r = $items[0].getBoundingClientRect();
                itemW = r.width || 1;
            }
            gap = readGapPx();
            step = itemW + gap;
        }

        function setTransform(tx, withTransition = true) {
            $track.css(
                "transition",
                withTransition
                    ? `transform ${settings.animMs}ms cubic-bezier(0.22,0.9,0.3,1)`
                    : "none"
            );
            $track.css("transform", `translateX(${tx}px)`);
        }

        function resetAutoplayIfAllowed() {
            // restart licznika tylko jeśli NIE ma hovera / focusu w obrębie rzędu
            if (isHover || isFocusWithin) return;
            stopAutoplay();
            startAutoplay();
        }

        // ---- Visibility: set range [start, end) visible, rest .is-off ----
        function setVisibleRange(start, end) {
            const n = $items.length;
            const s = Math.max(0, start);
            const e = Math.min(n, end);
            $items.each(function (i) {
                if (i >= s && i < e) {
                    this.classList.remove("is-off");
                    this.setAttribute("aria-hidden", "false");
                } else {
                    this.classList.add("is-off");
                    this.setAttribute("aria-hidden", "true");
                }
            });
        }

        // final range after stopping the animation
        function finalizeVisibility() {
            const leftOverscan = 1;
            const rightOverscan = 2;
            setVisibleRange(
                index - leftOverscan,
                index + visible + rightOverscan
            );
        }

        // preparing visibility for movement: union of old and new view
        function prepareVisibilityForMove(nextIndex) {
            const leftOverscan = 1;
            const rightOverscan = 2;
            const curStart = index - leftOverscan;
            const curEnd = index + visible + rightOverscan;
            const nxtStart = nextIndex - leftOverscan;
            const nxtEnd = nextIndex + visible + rightOverscan;
            const start = Math.min(curStart, nxtStart);
            const end = Math.max(curEnd, nxtEnd);
            setVisibleRange(start, end);
        }

        // ---- Buffer track (left buffer + core + right buffer) ----
        function rebuild() {
            visible = readTilesVisible();
            buffer = Math.max(1, visible + settings.bufferExtra);

            $track.empty();
            const left = $original.slice(-buffer).clone(true, true);
            const core = $original.clone(true, true);
            const right = $original.slice(0, buffer).clone(true, true);
            $track.append(left, core, right);
            $items = $track.children(".gallery-item");

            index = buffer; // start so that the first visible is the original
            measure();
            setTransform(-index * step, false);
            // reflow
            // eslint-disable-next-line no-unused-expressions
            $track[0].offsetHeight;

            finalizeVisibility();
        }

        // ---- Loop / teleport ----
        function normalizeAfterLoop() {
            const leftLimit = buffer;
            const rightLimit = buffer + originalCount;

            if (index >= rightLimit) {
                index -= originalCount;
                setTransform(-index * step, false);
                // eslint-disable-next-line no-unused-expressions
                $track[0].offsetHeight;
            } else if (index < leftLimit) {
                index += originalCount;
                setTransform(-index * step, false);
                // eslint-disable-next-line no-unused-expressions
                $track[0].offsetHeight;
            }
        }

        function next() {
            if (animating) return;
            animating = true;
            const target = index + 1;
            prepareVisibilityForMove(target);
            index = target;
            setTransform(-index * step, true);
        }

        function prev() {
            if (animating) return;
            animating = true;
            const target = index - 1;
            prepareVisibilityForMove(target);
            index = target;
            setTransform(-index * step, true);
        }

        function onAfterTransition() {
            animating = false;
            normalizeAfterLoop();
            finalizeVisibility();
        }

        function startAutoplay() {
            stopAutoplay();
            timer = setInterval(next, settings.autoplayInterval);
        }
        function stopAutoplay() {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        }

        // ---- Events ----
        $track.on("transitionend webkitTransitionEnd", onAfterTransition);

        // if (settings.pauseOnHover) {
        //     $row.on("mouseenter focusin", stopAutoplay);
        //     $row.on("mouseleave focusout", startAutoplay);
        // }

        if (settings.pauseOnHover) {
            $row.on("mouseenter", () => {
                isHover = true;
                stopAutoplay();
            });
            $row.on("mouseleave", () => {
                isHover = false;
                if (!isFocusWithin) startAutoplay();
            });

            $row.on("focusin", () => {
                isFocusWithin = true;
                stopAutoplay();
            });
            $row.on("focusout", (e) => {
                // wznawiaj tylko jeśli focus naprawdę wyszedł poza cały .gallery-row
                if (!$row[0].contains(e.relatedTarget)) {
                    isFocusWithin = false;
                    if (!isHover) startAutoplay();
                }
            });
        }

        // Click arrows: left (.tile-open), right (.tile-go)
        const nextThrottled = throttleLeading(() => {
            stopAutoplay();
            next();
            resetAutoplayIfAllowed();
        }, 300);

        $row.off("click", ".tile-go, .gallery-next").on(
            "click",
            ".tile-go, .gallery-next",
            function (e) {
                e.preventDefault();
                e.stopPropagation();
                nextThrottled();
            }
        );

        const prevThrottled = throttleLeading(() => {
            stopAutoplay();
            prev();
            resetAutoplayIfAllowed();
        }, 300);

        $row.off("click", ".tile-open, .gallery-prev").on(
            "click",
            ".tile-open, .gallery-prev",
            function (e) {
                e.preventDefault();
                e.stopPropagation();
                prevThrottled();
            }
        );

        // Keyboard
        $viewport.on("keydown", function (e) {
            if (e.key === "ArrowRight") {
                e.preventDefault();
                stopAutoplay();
                next();
                resetAutoplayIfAllowed();
            } else if (e.key === "ArrowLeft") {
                e.preventDefault();
                stopAutoplay();
                prev();
                resetAutoplayIfAllowed();
            }
        });

        // Swipe (mobile) – simple gesture, no dragging
        (function attachSwipe() {
            let sx = 0,
                sy = 0,
                moved = false,
                swiped = false;

            function onStart(ev) {
                stopAutoplay();
                swiped = false;
                moved = false;
                const t = ev.touches ? ev.touches[0] : ev;
                sx = t.clientX;
                sy = t.clientY;
            }
            function onMove(ev) {
                if (swiped) return;
                const t = ev.touches ? ev.touches[0] : ev;
                const dx = t.clientX - sx;
                const dy = t.clientY - sy;
                if (Math.abs(dx) < settings.swipeThreshold) return;
                // only when clearly horizontal
                if (Math.abs(dx) > Math.abs(dy)) {
                    ev.preventDefault();
                    moved = true;
                    swiped = true;
                    if (dx < 0) {
                        next();
                    } else {
                        prev();
                    }
                }
            }
            function onEnd() {
                if (!moved) {
                    // treat as tap - do nothing
                }
                resetAutoplayIfAllowed();
            }

            // passive:false to can call preventDefault on horizontal movement
            $viewport[0].addEventListener("touchstart", onStart, {
                passive: true,
            });
            $viewport[0].addEventListener("touchmove", onMove, {
                passive: false,
            });
            $viewport[0].addEventListener("touchend", onEnd, { passive: true });
        })();

        // Resize: rebuild if the number of visible tiles changes
        let lastVisible = null;
        function onResize() {
            const v = readTilesVisible();
            if (lastVisible === null) lastVisible = v;
            if (v !== lastVisible) {
                lastVisible = v;
                rebuild();
            } else {
                measure();
                setTransform(-index * step, false);
                finalizeVisibility();
            }
        }
        $(window).on("resize", onResize);

        // Start
        rebuild();
        startAutoplay();

        // Cleanup
        $row.data("galleryDestroy", function () {
            stopAutoplay();
            $(window).off("resize", onResize);
            $row.off();
            $track.off("transitionend webkitTransitionEnd", onAfterTransition);
        });

        // ---- Modal with product details ----
        const http = window.axios || axios; // use global instance from app.js if available

        function openGalleryModal(productSlug) {
            if (!productSlug) return;

            const locale = document.documentElement.dataset.locale || "pl";
            const url = `/${locale}/gallery/${encodeURIComponent(productSlug)}`;

            // console.log("openGalleryModal", productSlug, url);

            // Translated message texts
            const modalCloseText = t("gallery_modal_close", {}, "Zamknij");
            const modalLoadingText = t(
                "gallery_modal_loading",
                {},
                "Ładowanie…"
            );
            const modalErrorText = t("gallery_modal_error", {}, "Błąd");
            const modalErrorMessageText = t(
                "gallery_modal_error_message",
                {},
                "Nie udało się załadować danych."
            );

            // light "loader"
            const $root = $("#modal-root");
            $root.empty().append(`
      <div class="modal fade" id="galleryProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content border-0 bg-transparent shadow-none">
            <div class="d-flex justify-content-center align-items-center p-5">
              <div class="spinner-border" role="status" aria-label="${modalLoadingText}"></div>
            </div>
          </div>
        </div>
      </div>
    `);
            const loaderEl = document.getElementById("galleryProductModal");
            const loaderModal = new Modal(loaderEl, {
                backdrop: true,
                focus: true,
            });
            loaderModal.show();

            http.get(url, { headers: { Accept: "text/html" } })
                .then((res) => {
                    // Change the entire modal to the rendered HTML
                    $root.empty().append(res.data);

                    const modalEl = document.getElementById(
                        "galleryProductModal"
                    );

                    const modal = new Modal(modalEl, {
                        backdrop: true,
                        focus: true,
                    });

                    // Po zamknięciu — usuń z DOM aby nie dublować ID
                    modalEl.addEventListener("hidden.bs.modal", () => {
                        modal.dispose();
                        $("#galleryProductModal").remove();
                        unlockBodyScroll();
                    });

                    modal.show();
                })
                .catch((err) => {
                    console.error("Gallery modal load error:", err);
                    $root.empty().append(`
          <div class="modal fade" id="galleryProductModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">${modalErrorText}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="${modalCloseText}"></button>
                </div>
                <div class="modal-body">${modalErrorMessageText}</div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-gradient" data-bs-dismiss="modal">${modalCloseText}</button>
                </div>
              </div>
            </div>
          </div>
        `);
                    const modalEl = document.getElementById(
                        "galleryProductModal"
                    );

                    const modal = new Modal(modalEl, {
                        backdrop: true,
                        focus: true,
                    });

                    modalEl.addEventListener("hidden.bs.modal", () => {
                        modal.dispose();
                        $("#galleryProductModal").remove();
                        unlockBodyScroll();
                    });

                    modal.show();
                });
        }

        // Click on tile (but NOT on arrow buttons)
        const openModalThrottled = throttleLeading(
            (slug) => openGalleryModal(slug),
            300
        );

        $row.off("click", ".tile").on("click", ".tile", function (e) {
            if ($(e.target).closest(".tile-btn").length) return; // do not capture arrow buttons
            e.preventDefault();

            const slug =
                $(this).data("type") ||
                $(this).closest(".gallery-item").data("type");

            openModalThrottled(slug);
        });
    });
}
