<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThreadIdToMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('conversations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('community_id')->nullable()->default(NULL);
            $table->integer('entry_id')->nullable()->default(NULL);
            $table->text('subject')->nullable()->default(NULL);
            $table->timestamps();
            $table->SoftDeletes();
        });

        Schema::table('messages', function(Blueprint $table)
        {
            $table->integer('thread_id');
            $table->dropColumn('entry_id');
            $table->dropColumn('community_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversations');

        Schema::table('messages', function(Blueprint $table)
        {
            $table->dropColumn('thread_id');
            $table->integer('entry_id')->nullable()->default(NULL);
            $table->integer('community_id')->nullable()->default(NULL);
        });


    }
}
