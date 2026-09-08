<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerSolutionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // todo
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'solution_id' => 'numeric|required',
            'customer_id' => 'missing',
            'start_date' => 'date|nullable|required_with:recurring_period,start_date,end_date',
            'end_date' => 'date|nullable|required_with:recurring_period,start_date',
            'units' => 'numeric|min:0|required_with:price_per_unit,recurring_period,recurring_period_unit,vat_rate,start_date,end_date',
            'price_per_unit' => 'decimal:0,2|min:0|required_with:units,recurring_period,recurring_period_unit,vat_rate,start_date,end_date',
            'recurring_period' => 'numeric|nullable|required_with:recurring_period_unit,start_date,end_date|required_with:recurring_period,start_date,end_date',
            'recurring_period_unit' => 'string|nullable|required_with:recurring_period,start_date,end_date',
            'vat_rate' => 'decimal:0,2|min:0|max:0.99',
            'description' => 'string|nullable'
        ];
    }
}
