<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fleets', function (Blueprint $table) {

            $table->string('transmission')->nullable()->after('type');
            $table->string('fuel_type')->nullable()->after('transmission');
            $table->integer('seats')->nullable()->after('fuel_type');
            $table->string('year')->nullable()->after('seats');
            $table->decimal('price_per_day', 10, 2)->nullable()->after('price');
            $table->enum('status', ['available', 'unavailable'])->default('available')->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('fleets', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'transmission',
                'fuel_type',
                'seats',
                'year',
                'price_per_day',
                'status',
            ]);
        });
    }
};
