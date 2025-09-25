<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:1', 'max:150'],
            'last_name'  => ['required', 'string', 'min:1', 'max:150'],
            'email'      => ['required', 'string', 'email', 'max:75'],
            'message'    => ['required', 'string', 'min:1', 'max:2000'],
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.required' => __('messages.validation_required', ['field' => __('messages.contact_form_first_name')]),
            'first_name.min'      => __('messages.validation_min', ['field' => __('messages.contact_form_first_name'), 'min' => 1]),
            'first_name.max'      => __('messages.validation_max', ['field' => __('messages.contact_form_first_name'), 'max' => 150]),

            'last_name.required'  => __('messages.validation_required', ['field' => __('messages.contact_form_last_name')]),
            'last_name.min'       => __('messages.validation_min', ['field' => __('messages.contact_form_last_name'), 'min' => 1]),
            'last_name.max'       => __('messages.validation_max', ['field' => __('messages.contact_form_last_name'), 'max' => 150]),

            'email.required'      => __('messages.validation_required', ['field' => __('messages.contact_form_email')]),
            'email.email'         => __('messages.validation_email_invalid'),
            'email.max'           => __('messages.validation_max', ['field' => __('messages.contact_form_email'), 'max' => 75]),

            'message.required'    => __('messages.validation_required', ['field' => __('messages.contact_form_message')]),
            'message.min'         => __('messages.validation_min', ['field' => __('messages.contact_form_message'), 'min' => 1]),
            'message.max'         => __('messages.validation_max', ['field' => __('messages.contact_form_message'), 'max' => 2000]),
        ];
    }
}
