<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AddressBookRequest extends FormRequest
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
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', Rule::unique('address_book')->ignore($this->address_book)],
            'phone' => ['required', 'string', Rule::unique('address_book')->ignore($this->address_book)],
            'website' => ['required', 'string'],
            'age' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'nationality' => ['required', 'string'],
            'user_id' => ['required', 'numeric'],
            'created_at' => ['required'],
        ];
    }

    /**
     * prepare the validation
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->id(),
            'created_at' => now()
        ]);
    }
}
