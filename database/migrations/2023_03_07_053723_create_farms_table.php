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
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('local_government_id')->nullable();
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->unsignedBigInteger('prosperity_hub_id')->nullable();
            $table->integer('size');
            $table->foreignIdFor(\App\Models\FarmSizeUnit::class);
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('local_government_id')->references('id')->on('local_governments')->onDelete('cascade');
            $table->foreign('ward_id')->references('id')->on('wards')->onDelete('cascade');
            $table->foreign('prosperity_hub_id')->references('id')->on('prosperity_hubs')->onDelete('cascade');
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
