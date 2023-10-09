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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('kelompok_id');
            $table->string('cv_user');
            $table->enum('tipe_magang', ['mandiri', 'kelompok']);
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->string('status')->default('menunggu');
            $table->timestamps();
            $table->unsignedBigInteger('job_magang_id');
            $table->foreign('carrer_id')->references('id')->on('carrers')->onDelete('cascade');
            $table->foreign('job_magang_id')->references('id')->on('job_magang')->onDelete('cascade');
            $table->foreign('kelompok_id')->references('id')->on('kelompok')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
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
