<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            // Ajouter les colonnes manquantes
            $table->string('category')->nullable()->after('description');
            $table->enum('priority', ['basse', 'moyenne', 'élevée'])->nullable()->after('category');
            $table->date('due_date')->nullable()->after('priority');
            $table->date('completed_at')->nullable()->after('due_date');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->after('completed_at');
            $table->foreignId('created_by')->constrained('users')->after('assigned_to');
        });
    }

    public function down(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn(['category', 'priority', 'due_date', 'completed_at', 'assigned_to', 'created_by']);
        });
    }

};
