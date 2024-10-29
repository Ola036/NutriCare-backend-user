<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInformationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email,' . $this->user()->id,

            'health_conditions' => 'nullable|array',
            'health_conditions.*' => 'string|in:' . implode(',', array_values(config('data.health'))),

            'dietary_preferences' => 'nullable|array',
            'dietary_preferences.*' => 'string|in:' . implode(',', array_values(config('data.dietary'))),
        ];
    }
}
