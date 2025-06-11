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
        Schema::table('board_user', function (Blueprint $table) {
            $table->string('role')->default('member'); // roles: owner, admin, member, viewer
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('board_user', function (Blueprint $table) {
            //
        });
    }
};
