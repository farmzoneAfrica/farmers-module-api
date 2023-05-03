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
        Schema::create('farms', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class,'user_id');
            $table->string('latitude');
            $table->string('longitude');
            $table->foreignIdFor(\App\Models\State::class,'state_id');
            $table->foreignIdFor(\App\Models\LocalGovernment::class, 'local_government_id');
            $table->foreignIdFor(\App\Models\Ward::class, 'ward_id');
            $table->string('address', 255)->nullable();
            $table->string('landmark', 255)->nullable();
            $table->integer('size');
            $table->foreignIdFor(\App\Models\FarmSizeUnit::class);
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farms');
    }
};
