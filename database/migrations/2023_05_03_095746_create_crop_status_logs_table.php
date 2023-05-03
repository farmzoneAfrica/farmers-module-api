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
        Schema::create('crop_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\FarmCrop::class);
            $table->foreignIdFor(\App\Models\CropStatus::class, 'changed_from');
            $table->foreignIdFor(\App\Models\CropStatus::class, 'changed_to');
            $table->dateTime('time_changed');
            $table->dateTime('next_change_time');
            $table->enum('change_type', ['auto', 'manual']);
            $table->foreignIdFor(\App\Models\User::class, 'changed_by', )->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crop_status_logs');
    }
};
