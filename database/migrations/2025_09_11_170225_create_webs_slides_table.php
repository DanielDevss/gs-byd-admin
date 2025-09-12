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
        Schema::create('webs_slides', function (Blueprint $table) {
            $table->foreignId('web_id')->constrained('webs')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('slide_id')->constrained('slides')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webs_slides');
    }
};
