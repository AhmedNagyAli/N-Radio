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
        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('src');
            $table->enum('status',['0','1'])->default('0');
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->foreignId('language_id')->constrained()->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('station_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stations');
        Schema::dropIfExists('station_tag');
    }
};
