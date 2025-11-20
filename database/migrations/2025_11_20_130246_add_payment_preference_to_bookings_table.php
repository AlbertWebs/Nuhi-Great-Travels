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
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('payment_preference', ['pay_now', 'pay_later'])->default('pay_later')->after('status');
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->onDelete('set null')->after('payment_preference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['invoice_id']);
            $table->dropColumn(['payment_preference', 'invoice_id']);
        });
    }
};
