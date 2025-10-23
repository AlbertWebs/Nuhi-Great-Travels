<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fleet_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fleet_id')->constrained()->onDelete('cascade');
            $table->string('image_path'); // store image file path (e.g. 'uploads/fleets/image.jpg')
            $table->string('caption')->nullable(); // optional
            $table->integer('sort_order')->default(0); // optional for sorting images
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fleet_images');
    }
};
