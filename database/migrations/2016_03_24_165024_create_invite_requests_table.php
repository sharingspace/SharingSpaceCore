<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInviteRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_user_invites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->default(NULL);
            $table->string('name');
            $table->string('email');
            $table->integer('admin_id');
            $table->integer('community_id');
            $table->text('message')->nullable()->default(NULL);
            $table->date('accepted_at')->nullable()->default(NULL);
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
        Schema::dropIfExists('community_user_invites');
    }
}
