<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMessageDeletionFlags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function(Blueprint $table)
        {
            $table->integer('deleted_by_sender')->default(0);
            $table->integer('deleted_by_recipient')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function(Blueprint $table) {
            $table->dropColumn('deleted_by_sender');
            $table->dropColumn('deleted_by_recipient');
        });
    }
}
