<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIpLatlongToSearches extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('search_history', function(Blueprint $table)
		{
			$table->string('ip')->nullable();
			$table->decimal('latitude', 9, 2)->nullable()->default(NULL);
            $table->decimal('longitude', 9, 2)->nullable()->default(NULL);
			$table->integer('num_results')->nullable()->default(NULL);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('search_history', function(Blueprint $table)
		{
			$table->dropColumn(
				'ip', 'latitude', 'longitude', 'num_results'
			);
		});
	}

}
