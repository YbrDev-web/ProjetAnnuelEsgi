<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('boards', function (Blueprint $table) {
            $table->string('image')->nullable(); // URL ou nom de fichier
        });
    }

    public function down()
    {
        Schema::table('boards', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }

};
