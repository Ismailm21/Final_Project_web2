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
        Schema::create('pending_drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->string('area');
            $table->string('license')->unique();
            $table->string('vehicle_type')->default('motorcycle');
            $table->string('vehicle_number')->unique();
            $table->enum('pricing_model', ['fixed', 'perKilometer'])->default('fixed');
            $table->decimal('rate_per_km', 10, 2)->nullable();
            $table->decimal('fixed_rate', 10, 2)->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_drivers');
    }
};
