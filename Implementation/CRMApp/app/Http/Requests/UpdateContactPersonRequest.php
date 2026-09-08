<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContactPersonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // TODO: Change this to use proper authorization
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'missing',
            'gender' => 'required|string',
            'first_name' => 'required|string',
            'middle_name' => 'string|nullable',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'string|nullable',
            'function' => 'string|nullable'
        ];
    }
}
