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
        Schema::create('carousels', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g. "Car Rental"
            $table->string('subtitle')->nullable(); // e.g. "Your Best"
            $table->string('subtitle_two')->nullable(); // e.g. "Experience"
            $table->string('button_text')->nullable()->default('Read More');
            $table->string('button_link')->nullable(); // e.g. about page
            $table->string('video_link')->nullable(); // e.g. YouTube link
            $table->string('image')->nullable(); // background image
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carousels');
    }
};
