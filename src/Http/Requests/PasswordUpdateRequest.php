<?php

namespace Dedecube\Profile\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'current' => 'required|hash_match:'.auth()->user()->password,
            'new' => 'required|confirmed|min:6',
        ];
    }
}
