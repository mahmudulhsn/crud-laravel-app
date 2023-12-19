<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', Rule::unique('users')->ignore($this->user)],
            'phone' => ['required', 'string', Rule::unique('users')->ignore($this->user)],
            'password' => ['required', 'string', 'min:6'],
            'website' => ['required', 'string'],
            'age' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'nationality' => ['required', 'string'],
            'created_by' => ['required', 'numeric'],
            'email_verified_at' => ['nullable', 'string']
        ];

        if ($this->user) {
            $rules['password'] = ['nullable'];
        }

        return $rules;
    }

    /**
     * prepare the validation
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        $this->merge([
            'created_by' => auth()->id()
        ]);
    }
}
