<?php

namespace Dedecube\Profile\Http\Requests;

use Dedecube\Profile\Contracts\PasswordUpdateRequestInterface;
use Illuminate\Foundation\Http\FormRequest;

class PasswordUpdateRequest extends FormRequest implements PasswordUpdateRequestInterface
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {

        return [
            'current' => 'required|hash_match:'.auth()->user()->password,
            'new' => array_merge(['required', 'confirmed'], $this->passwordRules()),
        ];
    }

    public function passwordRules(): array
    {
        return [
            'min:6',
        ];
    }
}
