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
        Schema::create('konfirmed', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('carrer_id');
            $table->unsignedBigInteger('apply_id');
            $table->string('status');
            $table->integer('isSend')->default(0);
            $table->timestamps();
            $table->foreign('apply_id')->references('id')->on('apply');
            $table->foreign('carrer_id')->references('id')->on('carrers');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konfirmeds');
    }
};
