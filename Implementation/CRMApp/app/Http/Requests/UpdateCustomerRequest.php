<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // TODO: Change this to use proper authorization
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
            'customer_name' => 'required|string|max:255',
            'registration_number' => 'missing',
            'vat_number' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'address_street' => 'required|string|max:255',
            'address_house_number' => 'required|string|max:255',
            'address_postal_code' => 'required|string|max:255',
            'address_city' => 'required|string|max:255',
            'address_country' => 'required|string|max:255',
            'address_additional_information' => 'nullable|string|max:255',
        ];
    }
}
