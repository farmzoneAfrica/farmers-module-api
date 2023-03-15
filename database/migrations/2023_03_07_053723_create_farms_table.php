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
            $table->foreignId('user_id');
            $table->string('latitude');
            $table->string('longitude');
            $table->foreignId('state_id');
            $table->foreignId('local_government_id');
            $table->foreignId('ward_id');
            $table->string('address', 255)->nullable();
            $table->string('landmark', 255)->nullable();
            $table->integer('size');
            $table->string('unit');
            $table->enum('status', ['irrigation']);
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
