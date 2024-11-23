<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Validation\Rule;

class ClientUpdateRequest extends AdvisorAuthorizationRequest
{
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
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique(Client::class)->ignore($this->route('client')), 'required_without:phone'],
            'phone' => ['nullable', 'string', 'min:8', 'max:12', Rule::unique(Client::class)->ignore($this->route('client')), 'required_without:email'],
            'address' => ['nullable', 'string', 'max:255'],
        ];
    }
}
