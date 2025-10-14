<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('smile_id_verifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // user reference
            $table->string('job_id')->unique();                 // Smile ID job reference
            $table->string('job_type')->nullable();             // e.g. "5" or "1"
            $table->string('result_code')->nullable();
            $table->string('result_text')->nullable();
            $table->json('partner_params')->nullable();         // user_id, job_type, etc.
            $table->json('actions')->nullable();                // actions taken or metadata
            $table->json('images')->nullable();                 // base64 or file references
            $table->json('raw_response')->nullable();           // entire Smile ID callback payload
            $table->timestamp('completed_at')->nullable();      // when job finished
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('smile_id_verifications');
    }
};
