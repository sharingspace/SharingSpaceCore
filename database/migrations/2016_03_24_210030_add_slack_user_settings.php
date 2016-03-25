<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlackUserSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('communities_users', function(Blueprint $table)
        {
          $table->string('slack_name')->nullable()->default(NULL);
        });

        Schema::table('communities', function(Blueprint $table)
        {
          $table->string('slack_subdomain')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('communities_users', function(Blueprint $table)
        {
          $table->dropColumn('slack_name');
        });

        Schema::table('communities', function(Blueprint $table)
        {
          $table->dropColumn('slack_subdomain');
        });
    }
}
