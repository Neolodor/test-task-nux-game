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
        Schema::create('roulette_score', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable(false)->index();
            $table->uuid('link_id')->nullable(false)->index();
            $table->integer('score')->nullable(false)->index();
            $table->double('reward')->nullable(false)->index();
            $table->boolean('is_won')->nullable(false)->index();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('link_id')->references('id')->on('roulette_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roulette_score');
    }
};
