// Explanation:
// This is throttling (limiting the frequency of calls) implemented by requestAnimationFrame.
// Returns a function that will call the target function fn at most once per frame (usually ~60 FPS).
// If repeated calls come faster, they are grouped together and only one execution occurs in the next rAF.
// Ticking blocks further scheduling until fn is executed.
//
// When to use:
// For scroll or resize handlers, when you want to limit the work to one update per animation frame (e.g., updating classes, positions, lazy load checks).
// When the fn function is lightweight and you want to synchronize it to the frame to avoid layout thrashing.
export const rafThrottle = (fn) => {
    let ticking = false;
    return (...args) => {
        if (!ticking) {
            requestAnimationFrame(() => {
                fn(...args);
                ticking = false;
            });
            ticking = true;
        }
    };
};

// Explanation:
// Debounce delays the call to fn until wait ms has passed since the last call.
// Each subsequent call resets the timer. fn will only run if there is no subsequent call within the wait period.
//
// When to use:
// When you want to perform an operation after a series of events, e.g., a server query after input completion (autocomplete),
// or calculations after resize completion (e.g., layout adaptation).
// It is useful for minimizing costly operations performed repeatedly in a short period of time.
export function debounce(fn, wait = 100) {
    let t;
    return (...args) => {
        clearTimeout(t);
        t = setTimeout(() => fn(...args), wait);
    };
}

// Check if element is in viewport (with optional offset)
export function isElementInViewport(el, offset = 0) {
    if (!el) return false;
    const r = el.getBoundingClientRect();
    const vh = window.innerHeight || document.documentElement.clientHeight;
    return r.top <= vh - offset && r.bottom >= 0 + offset;
}

// Set --order CSS custom property on elements inside container for staggered animations
// Usage: setOrders(containerElement, '.stagger-item')
export function setOrders($container, selector = ".stagger-item") {
    // sets CSS custom prop --order for elements found by selector inside container
    const els = $container.querySelectorAll(selector);
    els.forEach((el, idx) => {
        const attr = el.getAttribute("data-order");
        const order = attr !== null ? Number(attr) : idx + 1;
        el.style.setProperty("--order", String(order));
    });
    return els;
}

// Helper: detect prefers-reduced-motion user setting
export function prefersReducedMotion() {
    try {
        return window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    } catch (e) {
        return false;
    }
}

//
// Helper: run callback once when element enters viewport (IntersectionObserver).
// Fallback to immediate check + scroll listeners if IO not available.
//
// IntersectionObserver is a native browser API that monitors the visibility of elements relative to the viewport (or another element—the root).
// It allows you to react when an element enters/exits the view without constant polling (effectively, without CPU load).
//
export function onceIntersection(el, cb, options = {}) {
    if (!el) return;
    if ("IntersectionObserver" in window) {
        const io = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    cb(entry);
                    io.unobserve(entry.target);
                    io.disconnect();
                }
            });
        }, options);
        io.observe(el);
        return () => {
            io.unobserve(el);
            io.disconnect();
        };
    }

    // fallback: simple immediate check + attach scroll listener until triggered
    const check = () => {
        if (isElementInViewport(el, options.rootMarginBottom || 0)) {
            cb();
            window.removeEventListener("scroll", check);
            window.removeEventListener("resize", check);
        }
    };
    window.addEventListener("scroll", check, { passive: true });
    window.addEventListener("resize", check, { passive: true });
    // initial
    check();
    return () => {
        window.removeEventListener("scroll", check);
        window.removeEventListener("resize", check);
    };
}

// Helper: run callback when DOM ready (similar to jQuery $(document).ready)
export function onReady(fn) {
    if (document.readyState !== "loading") {
        fn();
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

// safe helper (opcjonalnie) - używa window.__ gdy dostępne
export function t(key, replacements = {}, defaultValue = null) {
    // 1) prefer native window.__ if available
    if (typeof window.__ === "function") {
        return window.__(key, replacements, defaultValue);
    }

    // 2) otherwise use window.LaravelTranslations object
    const dict = window.LaravelTranslations || {};
    let s =
        typeof dict[key] !== "undefined"
            ? dict[key]
            : typeof defaultValue === "string"
            ? defaultValue
            : key;

    // apply replacements like ":count", ":field"
    Object.keys(replacements || {}).forEach(function (k) {
        s = ("" + s).split(":" + k).join(replacements[k]);
    });
    return s;
}

// Throttle z leading-edge (odrzuca kolejne wywołania < wait ms)
export function throttleLeading(fn, wait = 300) {
    let last = 0;
    return function (...args) {
        const now = Date.now();
        if (now - last < wait) return;
        last = now;
        return fn.apply(this, args);
    };
}

// Sprząta ewentualne osierocone tła i klasę na body
export function cleanupBackdrops() {
    $(".modal-backdrop").remove();
    document.body.classList.remove("modal-open");
    document.body.style.removeProperty("padding-right");
}

// Usuń wszystkie backdrops i zdejmij blokadę ze scrolla
export function unlockBodyScroll() {
    // Usuń wszystkie backdrops
    document.querySelectorAll(".modal-backdrop").forEach((el) => el.remove());
    // Zdejmij blokadę ze scrolla
    const body = document.body;
    body.classList.remove("modal-open");
    body.style.removeProperty("overflow");
    body.style.removeProperty("padding-right");
    body.removeAttribute("data-bs-padding-right");
    body.removeAttribute("data-bs-overflow");
    // Na wszelki wypadek (rzadko potrzebne, ale bezpieczne)
    document.documentElement.style.removeProperty("overflow");
}
