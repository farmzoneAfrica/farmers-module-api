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
        Schema::create('farm_crop_stages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crop_id');
            $table->unsignedBigInteger('stage_id');
            $table->integer('days_from');
            $table->integer('days_to');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farm_crop_stages');
    }
};
