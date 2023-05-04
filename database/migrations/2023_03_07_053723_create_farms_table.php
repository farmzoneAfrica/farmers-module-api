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
            $table->string('name');
            $table->string('latitude'); //coming from google place or any other available API
            $table->string('longitude');
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
