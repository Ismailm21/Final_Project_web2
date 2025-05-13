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
        Schema::create('chats', function (Blueprint $table) {

                $table->id();
                $table->dateTime('date_time');
                $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('cascade');

            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
                $table->text('message');
                $table->enum('message_type', ['text', 'attachment', 'call'])->default('text');
                $table->string('call_offer')->nullable();
                $table->boolean('is_received')->default(false);
                $table->timestamps();

                $table->index(['order_id']);
                $table->index(['sender_id', 'receiver_id']);
                $table->index(['is_received']);
            });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
