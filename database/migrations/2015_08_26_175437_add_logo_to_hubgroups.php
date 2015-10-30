<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLogoToHubgroups extends Migration {

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
			$table->string('logo')->nullable()->default(NULL);
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
				'logo'
			);
		});
	}

}
