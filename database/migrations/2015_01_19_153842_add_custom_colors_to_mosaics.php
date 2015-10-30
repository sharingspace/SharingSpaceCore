<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomColorsToMosaics extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('hubgroups', function ($table) {
           $table->string('topline_bg', 7)->default(NULL)->nullable();
           $table->string('topline_text', 7)->default(NULL)->nullable();
           $table->string('subnav_bg', 7)->default(NULL)->nullable();
           $table->string('subnav_text', 7)->default(NULL)->nullable();
           $table->string('page_bg', 7)->default(NULL)->nullable();
           $table->string('page_text', 7)->default(NULL)->nullable();
           $table->string('page_links', 7)->default(NULL)->nullable();
           $table->string('have_bg', 7)->default(NULL)->nullable();
           $table->string('want_bg', 7)->default(NULL)->nullable();
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
		Schema::table('hubgroups', function($table)
		{
			$table->dropColumn('topline_bg', 7);
			$table->dropColumn('topline_text', 7);
			$table->dropColumn('subnav_bg', 7);
			$table->dropColumn('subnav_text', 7);
			$table->dropColumn('page_bg', 7);
			$table->dropColumn('page_text', 7);
			$table->dropColumn('page_links', 7);
			$table->dropColumn('have_bg', 7);
			$table->dropColumn('want_bg', 7);
		});
	}

}
