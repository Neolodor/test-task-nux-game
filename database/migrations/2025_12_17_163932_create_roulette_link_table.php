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
        Schema::create('roulette_link', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable(false)->index();
            $table->uuid('slug')->nullable(false)->unique()->index();
            $table->dateTime('cancelled_at')->nullable()->index();
            $table->dateTime('expires_at')->nullable(false)->index();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roulette_link');
    }
};
