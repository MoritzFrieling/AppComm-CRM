<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSolutionRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'number' => 'required|numeric|min:0|unique:App\Models\Solution',
            'category' => 'required|string|max:255',
            'price_per_unit' => 'numeric|min:0',
            'units' => 'numeric|min:0',
            'vat_rate' => 'decimal:0,2|min:0|max:0.99',
            'recurring_period' => 'numeric|nullable',
            'recurring_period_unit' => 'string|nullable',
            'description' => 'nullable|string',
        ];
    }
}

