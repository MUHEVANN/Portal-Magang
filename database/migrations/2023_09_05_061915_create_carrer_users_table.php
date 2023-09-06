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
        Schema::create('carrer_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('carrer_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lowongan_id');
            $table->string('cv-user');
            $table->string('konfirmasi')->default('belum');
            $table->string('nama_kelompok')->default('Tidak Ada');
            $table->timestamps();
            $table->foreign('carrer_id')->references('id')->on('carrers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('lowongan_id')->references('id')->on('lowongans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrer_users');
    }
};
