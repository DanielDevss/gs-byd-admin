<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emails_has_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_id')->constrained('emails')->references('id')->cascadeOnDelete();
            $table->foreignId('form_id')->constrained('forms')->references('id')->cascadeOnDelete();
            $table->enum('type', ['to', 'cc', 'bcc'])->default('to');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails_has_forms');
    }
};
