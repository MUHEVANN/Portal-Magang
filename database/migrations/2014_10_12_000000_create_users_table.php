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
        Schema::create('kelompok', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('kelompok_id')->default(0);
            $table->integer('jabatan')->default(0);
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->string('alamat')->nullable();
            $table->integer('no_hp')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('verif_code')->nullable();
            $table->string('is_active')->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('kelompok_id')->references('id')->on('kelompok')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
