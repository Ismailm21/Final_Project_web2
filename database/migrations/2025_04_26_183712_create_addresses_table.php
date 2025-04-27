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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['home','work','other'])->default('other');
            $table->string('Street');
            $table->string('City');
            $table->string('State');
            $table->string('Country')->default('Lebanon');
            $table->string('PostalCode');
            $table->decimal('latitude',10,2);
            $table->decimal('longitude',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
