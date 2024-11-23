<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class AdvisorAuthorizationRequest extends FormRequest
{
    /**
     * Determine if the user (advisor) is authorized to make this request.
     */
    public function authorize(): bool
    {
        $client = $this->route('client');

        return $client && (Auth::check() && Auth::user()->id === $client->advisor_id);
    }
}
