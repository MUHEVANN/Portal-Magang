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
        Schema::create('apply_jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lowongan_id');
            $table->string('cv');
            $table->date('start');
            $table->date('end');
            $table->string('alamat');
            $table->string('pendidikan');
            $table->string('sekolah');
            $table->string('portofolio_url');
            $table->string('linkedin_url');
            $table->string('ig_url');
            $table->enum('gender', ['L', 'P']);
            $table->string('alasan');
            $table->string('konfirmasi')->default('belum');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('lowongan_id')->references('id')->on('lowongans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apply_jobs');
    }
};
