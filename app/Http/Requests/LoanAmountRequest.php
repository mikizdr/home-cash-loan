<?php

namespace App\Http\Requests;

class LoanAmountRequest extends AdvisorAuthorizationRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'loan_amount' => ['required', 'numeric', 'min:1', 'max:10000000000000'],
        ];
    }
}
