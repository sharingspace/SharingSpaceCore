<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('hp_featured', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->nullable()->default(NULL);
			$table->index('user_id');
			$table->integer('mosaic_id')->nullable()->default(NULL);
			$table->index('mosaic_id');
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
		 Schema::drop('hp_featured');

	}

}
