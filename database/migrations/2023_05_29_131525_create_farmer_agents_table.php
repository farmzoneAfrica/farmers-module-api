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
        Schema::create('farmer_agents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('farmer_id');
            $table->unsignedBigInteger('primary_agent_id');
            $table->unsignedBigInteger('secondary_agent_id');
            $table->timestamps();

            $table->foreign('farmer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('primary_agent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('secondary_agent_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmer_agents');
    }
};
