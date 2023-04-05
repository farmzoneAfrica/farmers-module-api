<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('face_biometrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->text('bio_data');
            $table->boolean('is_flagged')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('face_biometrics');
    }
};
