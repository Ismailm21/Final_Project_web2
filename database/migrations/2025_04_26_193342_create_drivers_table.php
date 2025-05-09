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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('area_id')->nullable()->constrained('areas')->onDelete('cascade');
            $table->foreignId('availability_id')->nullable()->constrained('availabilities')->onDelete('cascade'); // Make nullable
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Added: Link to users table
            $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
            $table->string('vehicle_type')->default('motorcycle');
            $table->string('vehicle_number')->unique();
            $table->enum('pricing_model', ['fixed', 'perKilometer'])->default('fixed');

            $table->decimal('rate_per_km', 10, 2)->nullable();
            $table->decimal('fixed_rate', 10, 2)->nullable();
            $table->decimal('rating', 3, 2)->default('0');
            $table->string('license')->unique();
            $table->enum('pricing_model', ['fixed', 'perKilometer'])->default('fixed');
            $table->decimal('rate_per_km', 10, 2)->nullable();
            $table->decimal('fixed_rate', 10, 2)->nullable();
            $table->decimal('rating', 3, 2)->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
