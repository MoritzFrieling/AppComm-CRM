<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'customer_name' => 'required|string|max:255',
            'registration_number' => 'required|string|max:255|unique:App\Models\Customer',
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
