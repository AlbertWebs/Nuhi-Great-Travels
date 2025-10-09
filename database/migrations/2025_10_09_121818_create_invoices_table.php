<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('fleet_id')->constrained('fleets')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // New user info (for manual entry)
            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->string('mpesa_number')->nullable();

            // Booking details
            $table->date('pickup_date');
            $table->date('dropoff_date');
            $table->integer('days');
            $table->decimal('price_per_day', 10, 2)->nullable();
            $table->decimal('total_price', 10, 2);

            // Status
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
