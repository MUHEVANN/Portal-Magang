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
            $table->string('host')->default('live.smtp.mailtrap.io');
            $table->string('port')->default('587');
            $table->string('username')->default('api');
            $table->string('password')->default('de98c838194ea2e369f9d9a5c8172b3d');
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
