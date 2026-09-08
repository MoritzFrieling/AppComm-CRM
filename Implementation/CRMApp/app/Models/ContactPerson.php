<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * This class is a Model Class for Contact Persons
 * Besides its own attributes there is a relation to a specific Customer
 */
class ContactPerson extends Model
{
    use HasFactory;

    protected $table = 'contact_persons';

    protected $fillable = [
        'customer_id',
        'gender',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone_number',
        'function'
    ];

    protected $attributes = [
        'customer_id' => '',
        'gender' => '',
        'first_name' => '',
        'middle_name' => '',
        'last_name' => '',
        'email' => '',
        'phone_number' => '',
        'function' => ''
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
