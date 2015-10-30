<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiletypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('tiletypes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('name')->nullable();
			$table->text('tooltip')->nullable();
			$table->softDeletes();
		});

		Schema::table('tiles', function ($table) {
            $table->text('tiletype_id')->nullable();
        });

        Schema::table('exchange_types', function ($table) {
            $table->text('tooltip')->nullable();
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
		Schema::drop('tiletypes');

		Schema::table('tiles', function($table)
		{
			$table->dropColumn('tiletype_id');
		});

		Schema::table('exchange_types', function($table)
		{
			$table->dropColumn('tooltip');
		});
	}

}
