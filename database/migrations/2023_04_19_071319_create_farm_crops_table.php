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
        Schema::create('farm_crops', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Farm::class);
            $table->foreignIdFor(\App\Models\Crop::class);
            $table->foreignIdFor(\App\Models\CropStatus::class);
            $table->date('last_changed');
            $table->date('date_completed')->nullable();
            $table->boolean('is_complete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farm_crops');
    }
};
