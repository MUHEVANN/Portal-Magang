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
        Schema::create('mail_settings', function (Blueprint $table) {
            $table->id();
            $table->string('transport')->default('smtp');
            $table->string('host')->default('sandbox.smtp.mailtrap.io');
            $table->string('port')->default('2525');
            $table->string('username')->default('38f3e177fe3b14');
            $table->string('password')->default('9bb188ed391bc4');
            $table->string('email')->default('evankusyanto03@gmail.com');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_settings');
    }
};