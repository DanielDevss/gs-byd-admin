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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name', 191)->unique();
            $table->string('slug', 191)->unique();
            $table->string('slug_byd')->nullable();
            $table->string('cover', 190);
            $table->string('banner', 190);
            $table->string('banner_attributes', 190);
            $table->string('technical_sheet', 190)->nullable();
            $table->char('year', 4);
            $table->timestamps();
        });

        Schema::create('vehicle_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->references('id')->cascadeOnDelete();
            $table->string('name', 190)->nullable();
            $table->string('text', 255)->nullable();
            $table->enum('section', ['Exterior', 'Interior', 'Rines']);
            $table->string('icon', 190);
            $table->string('preview', 190);
            $table->timestamps();
        });

        Schema::create('vehicle_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->references('id')->cascadeOnDelete();
            $table->string('title', 100);
            $table->string('description', 155)->nullable();
            $table->integer('position')->default(0);
            $table->timestamps();
        });

        Schema::create('vehicle_characteristics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->references('id')->cascadeOnDelete();
            $table->string('title', 100);
            $table->text('text')->nullable();
            $table->integer('position')->default(0);
            $table->timestamps();
        });

        Schema::create('vehicle_characteristic_element', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_characteristic_id')->constrained('vehicle_characteristics')->references('id')->cascadeOnDelete();
            $table->string('title', 125);
            $table->text('text')->nullable();
            $table->string('image', 190)->nullable();
            $table->integer('position')->default(0);
            $table->timestamps();
        });

        Schema::create('vehicle_pictures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->references('id')->cascadeOnDelete();
            $table->string('src', 190);
            $table->string('alt')->nullable();
            $table->timestamps();
        });

        Schema::create('vehicle_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name', 190)->unique();
            $table->string('price', 20);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('vehicle_settings');
        Schema::dropIfExists('vehicle_attributes');
        Schema::dropIfExists('vehicle_characteristics');
        Schema::dropIfExists('vehicle_characteristic_elements');
        Schema::dropIfExists('vehicle_pictures');
        Schema::dropIfExists('vehicle_versions');
    }
};
