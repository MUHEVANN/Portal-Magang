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
            $table->string('host')->default('smtp.gmail.com');
            $table->string('port')->default('587');
            $table->string('username')->default('evankusyanto03@gmail.com');
            $table->string('password')->default('wnojdpyzldaspnen');
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
