<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotificationsToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('users', function(Blueprint $table)
		{
			$table->boolean('notify_on_follow')->default(1);
			$table->boolean('notify_on_friendjoin')->default(1);
			$table->boolean('notify_on_fav')->default(0);
			$table->boolean('notify_on_match')->default(1);
			$table->boolean('notify_network_digest')->default(1);
			$table->char('ubsub_string', 60);

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
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn(
				'notify_on_follow','notify_on_friendjoin','notify_on_fav','notify_on_match','notify_network_digest','ubsub_string'
			);
		});
	}

}
