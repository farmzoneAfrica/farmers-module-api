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
        Schema::create('sent_otps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('otp');
            $table->string('phone');
            $table->enum('status', ['pending', 'sent', 'delivered', 'failed'])->default('pending');
            $table->string('reference');
            $table->string('gateway')->default('apexa');
            $table->string('callback_response')->nullable();
            $table->dateTime('time_completed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sent_otps');
    }
};
