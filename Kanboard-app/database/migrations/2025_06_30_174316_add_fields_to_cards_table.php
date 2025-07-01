<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->string('category')->nullable();        // Exemple : marketing, dev, etc.
            $table->enum('priority', ['basse', 'moyenne', 'élevée'])->nullable();
            $table->dateTime('completed_at')->nullable();  // Date de complétion
            $table->date('due_date')->nullable();          // Date limite
        });
    }

    public function down(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn(['category', 'priority', 'completed_at', 'due_date']);
        });
    }
};

