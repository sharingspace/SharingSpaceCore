<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeLatLongNullable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		DB::statement('ALTER TABLE `users` MODIFY `latitude` DECIMAL(9,2) NULL DEFAULT NULL');
		DB::statement('ALTER TABLE `users` MODIFY `longitude` DECIMAL(9,2) NULL DEFAULT NULL');
		DB::update('update users set latitude = NULL, longitude = NULL where latitude = "0.00" AND longitude="0.00"');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
