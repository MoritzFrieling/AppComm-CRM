<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Solution extends Model
{
    use HasFactory;

    protected $table = 'solutions';

    protected $fillable = [
        'title',
        'number',
        'category',
        'price_per_unit',
        'units',
        'recurring_period',
        'recurring_period_unit',
        'vat_rate',
        'description',
    ];

    /*public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'customer_id');
    }*/

    public function customer_solutions(): HasMany
    {
        return $this->hasMany(CustomerSolution::class, 'solution_id');
    }
}
