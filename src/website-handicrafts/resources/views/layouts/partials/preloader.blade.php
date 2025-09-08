<!-- Preloader: krążąca kulka + pierścień -->
<div id="preloader" class="preloader" role="status" aria-live="polite" aria-label="Trwa ładowanie strony">
    <div class="preloader-inner" aria-hidden="true">
        <!-- powiększone SVG: viewBox 0 0 160 160, center 80, r = 64 -->
        <svg class="preloader-ring" viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
            focusable="false">
            <defs>
                <linearGradient id="preloaderGradient" x1="0" x2="1" y1="0" y2="1">
                    <stop offset="0%" stop-color="var(--accent-start,#d64e72)" />
                    <stop offset="100%" stop-color="var(--accent-end,#b33b58)" />
                </linearGradient>
            </defs>

            <!-- frosted disc background (większy) -->
            <circle class="ring-bg" cx="80" cy="80" r="68" />

            <!-- stroke ring (r = 64) -->
            <circle class="ring-stroke" cx="80" cy="80" r="64" />

            <!-- bead (kulka) — większa; ustawiona na górze y = 80 - r -->
            <g class="bead-group">
                <circle class="bead" cx="80" cy="16" r="9" />
            </g>
        </svg>
    </div>
</div>
