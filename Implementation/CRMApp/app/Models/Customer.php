<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'registration_number',
        'vat_number',
        'email',
        'website',
        'address_street',
        'address_house_number',
        'address_postal_code',
        'address_city',
        'address_country',
        'address_additional_information',
        'active',
    ];

    protected $attributes = [
        'customer_name' => '',
        'registration_number' => '',
        'vat_number' => '',
        'email' => '',
        'website' => '',
        'address_street' => '',
        'address_house_number' => '',
        'address_postal_code' => '',
        'address_city' => '',
        'address_country' => '',
        'address_additional_information' => '',
        'active' => true,
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function contact_persons(): HasMany
    {
        return $this->hasMany(ContactPerson::class, 'customer_id');
    }

    public function customer_solutions(): HasMany
    {
        return $this->hasMany(CustomerSolution::class, 'customer_id');
    }
  
    public function gitlab_projects(): HasMany
    {
        return $this->hasMany(GitlabProject::class, 'customer_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'customer_id');
    }

}
