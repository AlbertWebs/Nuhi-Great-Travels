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
        Schema::table('fleets', function (Blueprint $table) {
            // Make the column nullable to avoid constraint errors on existing rows
            $table->foreignId('car_id')
                ->nullable()
                ->after('id')
                ->constrained('cars')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fleets', function (Blueprint $table) {
            // Drop the foreign key and column safely
            $table->dropForeign(['car_id']);
            $table->dropColumn('car_id');
        });
    }
};
