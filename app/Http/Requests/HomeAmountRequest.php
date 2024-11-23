<?php

namespace App\Http\Requests;

class HomeAmountRequest extends AdvisorAuthorizationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'property_value' => ['required', 'numeric', 'max:10000000000000'],
            'down_payment' => ['required', 'numeric', 'max:10000000000000', function ($attribute, $value, $fail) {
                if ($value > $this->input('property_value')) {
                    $fail('The down payment cannot be greater than the property value.');
                }
            }],
        ];
    }
}
