import $ from "jquery";
window.$ = window.jQuery = $;

export default function initFlashMessages(selector = ".flash-message") {
    const messages = document.querySelectorAll(selector);
    if (!messages.length) return () => {};

    messages.forEach((el) => {
        setTimeout(() => {
            el.classList.add("show");
        }, 100);

        setTimeout(() => {
            el.classList.remove("show");
            el.classList.add("hide");

            setTimeout(() => {
                el.remove();
            }, 400);
        }, 4000);
    });

    return () => {}; // cleanup
}
