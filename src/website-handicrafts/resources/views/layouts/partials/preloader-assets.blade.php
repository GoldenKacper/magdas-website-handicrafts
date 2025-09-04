{{-- push('head') i push('scripts') — musi być includowany przed @stack('head') --}}
@push('head')
    <style>
        :root {
            --accent-start: #d64e72;
            --accent-end: #b33b58;
            --ring-color: #f7d7de;

            --bead-size: 80px;

            --preloader-bg: rgba(255, 245, 247, 0.98);
            --preloader-opacity-duration: 0.4s;
            /* dopasowuje fade-out */
        }

        /* ---------- Preloader ---------- */
        .preloader {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--preloader-bg);
            z-index: 99999;
            transition: opacity var(--preloader-opacity-duration) ease-in, visibility var(--preloader-opacity-duration) linear;
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        /* hidden state (JS dodaje klasę) */
        .preloader.preloader-hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        /* inner wrapper */
        .preloader-inner {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* SVG sizing — powiększone */
        .preloader-ring {
            width: 5vw;
            height: 5vw;
            display: block;
        }


        @media (min-width: 2500px) {
            .preloader-ring {
                width: 3vw;
                height: 3vw;
            }
        }

        @media (max-width: 992px) {
            .preloader-ring {
                width: 11vw;
                height: 11vw;
            }
        }

        @media (max-width: 576px) {
            .preloader-ring {
                width: 15vw;
                height: 15vw;
            }
        }

        /* frosted disc background */
        .ring-bg {
            fill: rgba(255, 255, 255, 0.62);
        }

        /* stroke ring: r = 64 -> circumference ≈ 2πr ≈ 402 */
        .ring-stroke {
            fill: none;
            stroke: var(--ring-color);
            stroke-width: 4;
            stroke-linecap: round;

            stroke-dasharray: 402;
            /* ~2π*64 */
        }

        /* bead rotating around center (center 80,80) */
        .bead-group {
            transform-origin: var(--bead-size) var(--bead-size);
            animation: preloader-rotate 1.9s linear infinite;
        }

        .bead {
            fill: url(#preloaderGradient);
            filter: drop-shadow(0 6px 12px rgba(138, 43, 100, 0.12));
            transform-origin: var(--bead-size) var(--bead-size);
            transform-box: fill-box;
        }

        /* rotation keyframes */
        @keyframes preloader-rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* When hiding -> retract stroke and fade bead for smooth exit */
        .preloader.preloader-hidden .bead-group {
            animation-play-state: paused;
            opacity: 0;
            transition: opacity 0.3s ease-in;
        }

        /* tiny scale/shift during hide for extra polish */
        .preloader.preloader-hidden .preloader-inner {
            transform: scale(0.985) translateY(6px);
            transition: transform 0.4s ease-in;
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function() {
            const PRELOADER_ID = 'preloader';
            const HIDE_CLASS = 'preloader-hidden';
            const MAX_TIMEOUT = 8000;

            function hidePreloader() {
                const el = document.getElementById(PRELOADER_ID);
                if (!el) return;
                if (el.classList.contains(HIDE_CLASS)) return;
                el.classList.add(HIDE_CLASS);
                el.setAttribute('aria-hidden', 'true');
                setTimeout(function() {
                    if (el && el.parentNode) el.parentNode.removeChild(el);
                }, 400);
            }

            function onLoaded() {
                setTimeout(hidePreloader, 80);
            }

            if (window.jQuery) {
                (function($) {
                    $(window).on('load', onLoaded);
                    setTimeout(onLoaded, MAX_TIMEOUT);
                })(window.jQuery);
            } else {
                if (document.readyState === 'complete') {
                    onLoaded();
                } else {
                    window.addEventListener('load', onLoaded, {
                        passive: true
                    });
                    setTimeout(onLoaded, MAX_TIMEOUT);
                }
            }
        })();
    </script>
@endpush
