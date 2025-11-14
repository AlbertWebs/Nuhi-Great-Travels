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
        Schema::table('invoice_fleet', function (Blueprint $table) {
            if (! Schema::hasColumn('invoice_fleet', 'quantity')) {
                $table->unsignedInteger('quantity')->default(1)->after('fleet_id');
            }
        });

        Schema::table('estimate_fleet', function (Blueprint $table) {
            if (! Schema::hasColumn('estimate_fleet', 'quantity')) {
                $table->unsignedInteger('quantity')->default(1)->after('fleet_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_fleet', function (Blueprint $table) {
            if (Schema::hasColumn('invoice_fleet', 'quantity')) {
                $table->dropColumn('quantity');
            }
        });

        Schema::table('estimate_fleet', function (Blueprint $table) {
            if (Schema::hasColumn('estimate_fleet', 'quantity')) {
                $table->dropColumn('quantity');
            }
        });
    }
};
