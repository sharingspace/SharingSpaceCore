<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunityApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_apis', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('community_id');
            $table->unsignedInteger('oauth_clients_id');


            $table->foreign('community_id')->references('id')->on('communities')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('community_apis');
    }
}
