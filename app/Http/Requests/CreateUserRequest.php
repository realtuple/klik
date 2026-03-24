<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'username' => strtolower($this->username),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $reserved = ['auth', 'profiles', 'status'];

        return [
            'display_name' => ['required'],
            'username' => ['required', 'min:3', 'max:20', 'regex:/^[A-Za-z0-9._]+$/', 'unique:profiles,username', Rule::notIn($reserved)],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'date' => ['required', Rule::date()->beforeOrEqual(today()->subYears(13))],
        ];
    }
}
