<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesapal_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_id')->unique();
            $table->string('merchant_reference')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_status_description')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('currency')->nullable();
            $table->string('sender_phone')->nullable();
            $table->string('sender_name')->nullable();
            $table->json('raw_response')->nullable(); // for full API response storage
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesapal_transactions');
    }
};
