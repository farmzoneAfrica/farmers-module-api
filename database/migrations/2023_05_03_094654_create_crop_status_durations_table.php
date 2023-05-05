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
        Schema::create('crop_status_durations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Crop::class);
            $table->foreignIdFor(\App\Models\CropStatus::class);
            $table->integer('order');
            $table->boolean('is_final')->default(0);
            $table->integer('duration')->nullable()->comment('in days');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crop_status_durations');
    }
};
