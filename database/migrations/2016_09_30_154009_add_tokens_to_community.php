<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTokensToCommunity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('communities', function(Blueprint $table)
        {
            $table->string('slack_slash_want_token')->nullable()->default(null);
            $table->string('slack_slash_have_token')->nullable()->default(null);
            $table->string('slack_slash_members_token')->nullable()->default(null);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->dropColumn('slack_slash_want_token');
            $table->dropColumn('slack_slash_have_token');
            $table->dropColumn('slack_slash_members_token');
        });
    }
}
