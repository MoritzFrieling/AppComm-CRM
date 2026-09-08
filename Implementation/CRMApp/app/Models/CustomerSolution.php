<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * This Model models the relationship between a Customer and a Solution
 * It contains details about start/end dates, billing models and pricing, as well as a description
 */
class CustomerSolution extends Model
{
    use HasFactory;

    protected $table = 'customer_solutions';

    protected $fillable = [
        'solution_id',
        'customer_id',
        'start_date',
        'end_date',
        'units',
        'price_per_unit',
        'recurring_period',
        'recurring_period_unit',
        'vat_rate',
        'description'
    ];

    protected $attributes = [
        'solution_id' => '',
        'customer_id' => '',
        'start_date' => '',
        'end_date' => '',
        'units' => '',
        'price_per_unit' => '',
        'recurring_period' => '',
        'recurring_period_unit' => '',
        'vat_rate' => '',
        'description' => ''
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function solution(): BelongsTo
    {
        return $this->belongsTo(Solution::class, 'solution_id');
    }
}
