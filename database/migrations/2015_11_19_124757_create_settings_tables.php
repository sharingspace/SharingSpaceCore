<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      /*
      * Create domain blacklist table
      */
      Schema::create('domain_blacklist', function(Blueprint $table)
  		{
  			$table->increments('id');
  			$table->string('domain');
  			$table->timestamps();
  		});

      Schema::create('settings', function($table) {
        $table->increments('id')->unsigned();
        $table->string('site_name', 255);
        $table->dateTime('completed_at')->nullable();

      });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('domain_blacklist');

    }
}
