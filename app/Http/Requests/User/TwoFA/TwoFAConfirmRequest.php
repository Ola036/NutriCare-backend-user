<?php

namespace App\Http\Requests\User\TwoFA;

use Illuminate\Foundation\Http\FormRequest;

class TwoFAConfirmRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|digits:6'
        ];
    }
}
