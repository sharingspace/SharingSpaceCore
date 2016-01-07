<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStripeIdToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::table('users', function ($table) {
         $table->string('stripe_id')->nullable()->default(NULL);
         $table->text('stripe_discount');
       });
     }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('users', function ($table) {
        $table->dropColumn('stripe_id');
        $table->dropColumn('stripe_discount');
      });
    }
}
