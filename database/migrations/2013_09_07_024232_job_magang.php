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
        Schema::create('job_magang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('carrer_id');
            $table->string('name');
            $table->text('desc');
            $table->text('benefit');
            $table->text('kualifikasi');
            $table->string('gambar');
            $table->timestamps();
            $table->foreign('carrer_id')->references('id')->on('carrers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};