<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('payment_type')->nullable()->after('whatsapp');
            $table->string('payment_number')->nullable()->after('payment_type');
            $table->string('payment_name')->nullable()->after('payment_number');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['payment_type', 'payment_number', 'payment_name']);
        });
    }
};
