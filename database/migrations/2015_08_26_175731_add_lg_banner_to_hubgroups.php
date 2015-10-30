<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLgBannerToHubgroups extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('hubgroups', function(Blueprint $table)
		{
			$table->string('lg_banner')->nullable()->default(NULL);
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
		Schema::table('hubgroups', function(Blueprint $table)
		{
			$table->dropColumn(
				'lg_banner'
			);
		});
	}

}
