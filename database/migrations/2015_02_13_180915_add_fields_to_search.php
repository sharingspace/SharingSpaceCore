<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToSearch extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('search_history', function ($table) {
           $table->string('unit', 5)->default(NULL)->nullable();
           $table->integer('distance')->default(NULL)->nullable();
           $table->integer('tiletype_id')->default(NULL)->nullable();
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
		Schema::table('search_history', function($table)
		{

			$table->dropColumn('unit');
			$table->dropColumn('distance');
			$table->dropColumn('tiletype_id');
		});
	}

}
