import $ from "jquery";
import { t } from "../utils.js";
window.$ = window.jQuery = $;

/**
 * initContactForm(formSelector = 'form.contact-panel')
 * - Autosize textarea with a maximum height (data-max-height on textarea or default)
 * - Basic validation: name/last (1..150), email (1..75 + pattern), message (1..2000)
 * - Toggle classes on .input-icon__icon -> 'is-valid' / 'is-invalid'
 * - Enable submit when all fields valid
 * - Arrow navigation and Enter handling
 *
 * Returns a destroy() function to remove event listeners.
 */
export default function initContactForm(formSelector = "form.contact-panel") {
    const $form = $(formSelector);
    if (!$form.length) return () => {};

    // inputs
    const $firstName = $form.find("#contact_first_name");
    const $lastName = $form.find("#contact_last_name");
    const $email = $form.find("#contact_email");
    const $message = $form.find("#contact_message");
    const $submit = $form.find('button[type="submit"]');
    const $reset = $form.find('button[type="reset"]');

    // feedback nodes (optional)
    const $firstFb = $form.find("#contact_first_name_feedback");
    const $lastFb = $form.find("#contact_last_name_feedback");
    const $emailFb = $form.find("#contact_email_feedback");
    const $messageFb = $form.find("#contact_message_feedback");

    // rules
    const RULES = {
        firstName: { min: 1, max: 150 },
        lastName: { min: 0, max: 150 }, // optional; set min:1 if required
        email: { min: 1, max: 75 },
        message: { min: 1, max: 2000 },
    };

    const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    function iconFor($control) {
        return $control
            .closest(".input-icon")
            .find(".input-icon__icon")
            .first();
    }

    function showFeedback($control, msg) {
        const fbId = $control.attr("id") + "_feedback";
        const $fb = $form.find("#" + fbId);
        if ($fb.length) {
            if (msg) {
                $fb.removeClass("visually-hidden").text(msg);
            } else {
                $fb.addClass("visually-hidden").text("");
            }
        }
    }

    function setValidState($control, state, msg = "") {
        const $icon = iconFor($control);
        if (!$icon.length) return;
        $icon.removeClass("is-valid is-invalid");

        if (state === "valid") {
            $icon.addClass("is-valid");
            $control.attr("aria-invalid", "false");
            showFeedback($control, "");
        } else if (state === "invalid") {
            $icon.addClass("is-invalid");
            $control.attr("aria-invalid", "true");
            showFeedback($control, msg);
        } else {
            // none
            $control.removeAttr("aria-invalid");
            showFeedback($control, "");
        }
    }

    // localized field labels (try keys first, fallback to sensible default)
    const labelFirst = t("contact_form_first_name", {}, "First name");
    const labelLast = t("contact_form_last_name", {}, "Last name");
    const labelEmail = t("contact_form_email", {}, "Email");
    const labelMessage = t("contact_form_message", {}, "Message");

    // validators return { state: 'none' | 'valid' | 'invalid', reason?: 'too-long'|'bad-format' }
    function validateName(value, { min, max }) {
        if (!value || value.length === 0) return { state: "none" };
        if (value.length > max) return { state: "invalid", reason: "too-long" };
        if (value.length < min) return { state: "none" }; // treat as empty -> not invalid immediately
        return { state: "valid" };
    }

    function validateEmail(value, { min, max }) {
        if (!value || value.length === 0) return { state: "none" };
        if (value.length > max) return { state: "invalid", reason: "too-long" };
        if (!EMAIL_RE.test(value))
            return { state: "invalid", reason: "bad-format" };
        if (value.length < min) return { state: "none" };
        return { state: "valid" };
    }

    function validateMessage(value, { min, max }) {
        if (!value || value.length === 0) return { state: "none" };
        if (value.length > max) return { state: "invalid", reason: "too-long" };
        if (value.length < min) return { state: "none" };
        return { state: "valid" };
    }

    function updateSubmitState() {
        const allValid =
            iconFor($firstName).hasClass("is-valid") &&
            iconFor($lastName).hasClass("is-valid") &&
            iconFor($email).hasClass("is-valid") &&
            iconFor($message).hasClass("is-valid");
        $submit.prop("disabled", !allValid);
    }

    // handlers using t() for messages
    function onFirstNameInput() {
        const v = $firstName.val() ? String($firstName.val()).trim() : "";
        const r = validateName(v, RULES.firstName);
        if (r.state === "valid") {
            setValidState($firstName, "valid");
        } else if (r.state === "invalid") {
            const msg = t(
                "validation_max",
                { field: labelFirst, max: RULES.firstName.max },
                `${labelFirst} too long (max ${RULES.firstName.max}).`
            );
            setValidState($firstName, "invalid", msg);
        } else {
            setValidState($firstName, "none");
        }
        updateSubmitState();
    }

    function onLastNameInput() {
        const v = $lastName.val() ? String($lastName.val()).trim() : "";
        const r = validateName(v, RULES.lastName);
        if (r.state === "valid") {
            setValidState($lastName, "valid");
        } else if (r.state === "invalid") {
            const msg = t(
                "validation_max",
                { field: labelLast, max: RULES.lastName.max },
                `${labelLast} too long (max ${RULES.lastName.max}).`
            );
            setValidState($lastName, "invalid", msg);
        } else {
            setValidState($lastName, "none");
        }
        updateSubmitState();
    }

    function onEmailInput() {
        const v = $email.val() ? String($email.val()).trim() : "";
        const r = validateEmail(v, RULES.email);
        if (r.state === "valid") {
            setValidState($email, "valid");
        } else if (r.state === "invalid") {
            let msg = "";
            if (r.reason === "bad-format") {
                msg = t(
                    "validation_email_invalid",
                    {},
                    "Please enter a valid email address."
                );
            } else {
                msg = t(
                    "validation_max",
                    { field: labelEmail, max: RULES.email.max },
                    `${labelEmail} too long (max ${RULES.email.max}).`
                );
            }
            setValidState($email, "invalid", msg);
        } else {
            setValidState($email, "none");
        }
        updateSubmitState();
    }

    function onMessageInput() {
        const v = $message.val() ? String($message.val()).trim() : "";
        const r = validateMessage(v, RULES.message);
        if (r.state === "valid") {
            setValidState($message, "valid");
        } else if (r.state === "invalid") {
            const msg = t(
                "validation_max",
                { field: labelMessage, max: RULES.message.max },
                `${labelMessage} too long (max ${RULES.message.max}).`
            );
            setValidState($message, "invalid", msg);
        } else {
            setValidState($message, "none");
        }
        updateSubmitState();
    }

    // keyboard navigation
    const controls = [$firstName, $lastName, $email, $message];

    function focusIndex(i) {
        if (i < 0 || i >= controls.length) return;
        controls[i].focus();
        controls[i][0].scrollIntoView({ block: "nearest", behavior: "smooth" });
    }

    function onControlKeydown(e) {
        const $el = $(e.currentTarget);
        const idx = controls.findIndex(($c) => $c[0] === $el[0]);
        if (e.key === "ArrowDown") {
            e.preventDefault();
            focusIndex(Math.min(idx + 1, controls.length - 1));
        } else if (e.key === "ArrowUp") {
            e.preventDefault();
            focusIndex(Math.max(idx - 1, 0));
        } else if (e.key === "Enter") {
            if ($el.is("textarea")) {
                if (e.ctrlKey || e.metaKey) {
                    e.preventDefault();
                    trySubmit();
                }
                return;
            }
            e.preventDefault();
            if (idx < controls.length - 1) {
                focusIndex(idx + 1);
            } else {
                trySubmit();
            }
        }
    }

    function trySubmit() {
        // run all validators to be sure
        onFirstNameInput();
        onLastNameInput();
        onEmailInput();
        onMessageInput();

        const allValid =
            iconFor($firstName).hasClass("is-valid") &&
            iconFor($lastName).hasClass("is-valid") &&
            iconFor($email).hasClass("is-valid") &&
            iconFor($message).hasClass("is-valid");

        if (allValid) {
            $form.trigger("submit:validated");
            if ($form.attr("action") === "#" || !$form.attr("action")) {
                // dev behaviour: simulate submit success
                const okMsg = t(
                    "validation_all_valid",
                    {},
                    "All fields valid."
                );
                // optional: show a toast or console
                console.log(okMsg);
                $form[0].reset();
                setValidState($firstName, "none");
                setValidState($lastName, "none");
                setValidState($email, "none");
                setValidState($message, "none");
                updateSubmitState();
            } else {
                $form.off("submit.contactForm");
                $form.submit();
            }
        } else {
            $form.find(".input-icon__icon.is-invalid").each(function () {
                const $wrap = $(this).closest(".input-icon");
                $wrap.addClass("shake");
                setTimeout(() => $wrap.removeClass("shake"), 420);
            });
            // optionally focus first invalid
            const $firstInvalid = $form
                .find(".input-icon__icon.is-invalid")
                .first();
            if ($firstInvalid.length) {
                $firstInvalid
                    .closest(".input-icon")
                    .find("input,textarea")
                    .focus();
            }
        }
    }

    function onFormSubmit(e) {
        if ($form.attr("action") === "#" || !$form.attr("action")) {
            e.preventDefault();
            trySubmit();
        } else {
            onFirstNameInput();
            onLastNameInput();
            onEmailInput();
            onMessageInput();
            const allValid =
                iconFor($firstName).hasClass("is-valid") &&
                iconFor($lastName).hasClass("is-valid") &&
                iconFor($email).hasClass("is-valid") &&
                iconFor($message).hasClass("is-valid");
            if (!allValid) {
                e.preventDefault();
                trySubmit();
            }
        }
    }

    function onFormReset() {
        setTimeout(() => {
            setValidState($firstName, "none");
            setValidState($lastName, "none");
            setValidState($email, "none");
            setValidState($message, "none");
            updateSubmitState();
        }, 10);
    }

    // bind events
    $firstName
        .on("input.contactForm", onFirstNameInput)
        .on("keydown.contactForm", onControlKeydown);
    $lastName
        .on("input.contactForm", onLastNameInput)
        .on("keydown.contactForm", onControlKeydown);
    $email
        .on("input.contactForm", onEmailInput)
        .on("keydown.contactForm", onControlKeydown);
    $message
        .on("input.contactForm", onMessageInput)
        .on("keydown.contactForm", onControlKeydown);

    $form.on("submit.contactForm", onFormSubmit);
    $reset.on("click.contactForm", onFormReset);

    // clicking icon focuses the input
    $form.on("click.contactForm", ".input-icon__icon", function () {
        $(this).closest(".input-icon").find("input,textarea").focus();
    });

    // init states
    onFirstNameInput();
    onLastNameInput();
    onEmailInput();
    onMessageInput();
    updateSubmitState();

    // cleanup
    function destroy() {
        $firstName.off(".contactForm");
        $lastName.off(".contactForm");
        $email.off(".contactForm");
        $message.off(".contactForm");
        $form.off(".contactForm");
        $reset.off(".contactForm");
    }

    return destroy;
}
