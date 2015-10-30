<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSingularFieldToTiletypes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('tiletypes', function ($table) {
           $table->string('singular', 20)->default(NULL)->nullable();
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
		Schema::table('tiletypes', function($table)
		{
			$table->dropColumn('singular', 7);
		});
	}

}
