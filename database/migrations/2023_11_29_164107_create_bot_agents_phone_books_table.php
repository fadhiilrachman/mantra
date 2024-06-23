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
        Schema::create('bot_agents_phone_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bot_agents_id')->constrained()->onDelete('cascade');
            $table->foreignId('phone_books_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bot_agents_phone_books');
    }
};
