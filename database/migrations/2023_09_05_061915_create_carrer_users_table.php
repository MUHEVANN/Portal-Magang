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
        Schema::create('apply', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('carrer_id');
            $table->unsignedBigInteger('kelompok_id');
            $table->string('cv_user');
            $table->string('status')->default('menunggu');
            $table->timestamps();
            $table->foreign('carrer_id')->references('id')->on('carrers')->onDelete('cascade');
            $table->foreign('kelompok_id')->references('id')->on('kelompok')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apply');
    }
};
