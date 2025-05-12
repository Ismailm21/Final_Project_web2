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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade'); // Added: who placed the order
            $table->foreignId('driver_id')->constrained('drivers')->onDelete('cascade');
            $table->foreignId('pickup_address_id')->constrained('addresses')->onDelete('cascade');
            $table->foreignId('dropoff_address_id')->constrained('addresses')->onDelete('cascade');
            $table->decimal('package_weight', 10, 2)->default(0);
            $table->integer('package_size_l')->nullable();
            $table->integer('package_size_w')->nullable();
            $table->integer('package_size_h')->nullable();
            $table->date('delivery_date')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->string('tracking_code', 50)->nullable(); //order
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
