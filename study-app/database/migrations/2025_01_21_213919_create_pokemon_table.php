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
        Schema::create('pokemon', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('base_experience');
            $table->integer('height');
            $table->integer('weight');
            $table->json('abilities');
            $table->json('cries');
            $table->json('forms');
            $table->json('game_indices');
            $table->json('held_items');
            $table->json('moves');
            $table->json('sprites');
            $table->json('stats');
            $table->json('types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemon');
    }
};
