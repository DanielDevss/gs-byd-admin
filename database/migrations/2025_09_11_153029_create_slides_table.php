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
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->integer('position')->default(0);
            $table->string('src');
            $table->string('name', 100);
            $table->string('alt', 190)->nullable();
            $table->string('url', 255)->nullable();
            $table->enum('section', ['Main', 'Modelo']);
            $table->enum('status', ['Publicado', 'Inactivo', 'Programado'])->default('Publicado');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};
