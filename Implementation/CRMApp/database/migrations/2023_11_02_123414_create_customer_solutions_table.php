<?php

use App\Models\Customer;
use App\Models\Solution;
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
        Schema::create('customer_solutions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class, 'customer_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Solution::class, 'solution_id')->constrained();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('units');
            $table->string('price_per_unit');
            $table->string('recurring_period')->nullable();
            $table->string('recurring_period_unit')->nullable();
            $table->string('vat_rate');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_solutions');
    }
};
