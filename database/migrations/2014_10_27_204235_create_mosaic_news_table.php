<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMosaicNewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		 // Update the users table

        Schema::create('mosaic_news', function ($table) {
            $table->increments('id')->unsigned();
            $table->text('news')->nullable();
            $table->integer('hubgroup_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
		 Schema::drop('mosaic_news');

	}

}
