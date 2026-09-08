<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('vat_number');
            $table->string('registration_number')->unique();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('address_street');
            $table->string('address_house_number');
            $table->string('address_postal_code');
            $table->string('address_city');
            $table->string('address_country');
            $table->string('address_additional_information')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
