<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommunityIdToSubscriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::table('stripe_subscriptions', function ($table) {
         $table->integer('community_id')->nullable()->default(NULL);
       });
     }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('stripe_subscriptions', function ($table) {
         $table->dropColumn('community_id');
      });
    }
}
