<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommnunityTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
      /**
       * Table: communities
       */
      Schema::create('communities', function($table)
      {
        $table->engine = 'InnoDB';
        $table->increments('id');
        $table->string('name', 99);
        $table->integer('parent_id')->nullable()->default(NULL);
        $table->text('about')->nullable()->default(NULL);
        $table->string('location', 99)->nullable()->default(NULL);
        $table->string('facebook', 255)->nullable()->default(NULL);
        $table->string('twitter', 255)->nullable()->default(NULL);
        $table->string('website', 255)->nullable()->default(NULL);
        $table->string('google', 255)->nullable()->default(NULL);
        $table->string('pinterest', 255)->nullable()->default(NULL);
        $table->string('youtube', 255)->nullable()->default(NULL);
        $table->string('group_type', 1)->default("O");
        $table->timestamp('created_at')->nullable()->default(NULL);
        $table->timestamp('updated_at')->nullable()->default(NULL);
        $table->dateTime('deleted_at')->nullable()->default(NULL);
        $table->string('created_by', 11)->nullable()->default(NULL);
        $table->decimal('latitude', 9,2)->nullable()->default(NULL);
        $table->decimal('longitude', 9,2)->nullable()->default(NULL);
        $table->integer('focus_id')->nullable()->default(NULL);
        $table->string('cover_img', 100)->nullable()->default(NULL);
        $table->string('profile_img', 100)->nullable()->default(NULL);
        $table->string('logo', 20)->nullable()->default(NULL);
        $table->string('subdomain', 100)->nullable()->default(NULL);
        $table->dateTime('subdomain_expires_at')->nullable()->default(NULL);
        $table->dateTime('limittypes_expires_at')->nullable()->default(NULL);
        $table->string('welcome_text', 255)->nullable()->default(NULL);
      });


	    Schema::create('communities_users', function($table) {
        $table->engine = 'InnoDB';
        $table->increments('id');
        $table->integer('user_id')->nullable();
        $table->integer('community_id')->nullable();
        $table->integer('is_admin');
    });


	    Schema::create('communities_invites', function($table)
      {
        $table->engine = 'InnoDB';
        $table->increments('id');
        $table->integer('community_id')->nullable()->default(NULL);
        $table->string('email', 255)->nullable()->default(NULL);
        $table->string('token', 255)->nullable()->default(NULL);
        $table->boolean('is_admin');
        $table->timestamp('created_at')->nullable()->default(NULL);
        $table->timestamp('updated_at')->nullable()->default(NULL);
        $table->dateTime('accepted_at')->nullable()->default(NULL);
        $table->integer('invited_by')->nullable()->default(NULL);
      });


    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
      Schema::dropIfExists('communities');
      Schema::dropIfExists('communities_users');
      Schema::dropIfExists('communities_invites');
    }
}
