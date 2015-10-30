<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeywordNomalized extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('keywords', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('tile_id')->nullable();
            $table->string('phrase', 40)->default(NULL)->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		 Schema::drop('keywords');
	}

}
