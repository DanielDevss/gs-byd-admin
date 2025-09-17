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
        Schema::create('emails_has_webs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_id')->constrained('emails')->references('id')->cascadeOnDelete();
            $table->foreignId('web_id')->constrained('webs')->references('id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails_has_webs');
    }
};
