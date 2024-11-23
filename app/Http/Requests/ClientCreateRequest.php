<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientCreateRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:clients', 'required_without:phone'],
            'phone' => ['nullable', 'string', 'min:8', 'max:12', 'unique:clients', 'required_without:email'],
            'address' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required_without' => __('The email field is required when phone is not provided.'),
            'phone.required_without' => __('The phone field is required when email is not provided.'),
        ];
    }
}
