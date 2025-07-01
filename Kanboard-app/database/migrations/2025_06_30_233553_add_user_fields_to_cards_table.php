<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserFieldsToCardsTable extends Migration
{
    public function up()
    {
        Schema::table('cards', function (Blueprint $table) {
            if (!Schema::hasColumn('cards', 'assigned_to')) {
                $table->unsignedBigInteger('assigned_to')->nullable()->after('id');
                $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            }

            if (!Schema::hasColumn('cards', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('id');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropForeign(['assigned_to']);
            $table->dropColumn('assigned_to');

            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });
    }
}
