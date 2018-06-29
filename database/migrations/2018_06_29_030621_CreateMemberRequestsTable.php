<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('request_type', array('Role'));
            $table->integer('community_id')->nullable()->default(NULL);
            $table->integer('user_id');
            $table->integer('role_id')->default(0);
            $table->tinyInteger('is_accepted')->default(0);
            $table->tinyInteger('is_rejected')->default(0);
            $table->text('custom_text')->nullable();
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
        Schema::dropIfExists('member_requests');
    }
}
