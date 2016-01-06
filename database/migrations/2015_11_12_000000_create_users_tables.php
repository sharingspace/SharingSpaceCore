<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      /*
      * Create users table
      */
      Schema::create('users', function (Blueprint $table)
      {
        $table->engine = 'InnoDB';
        $table->increments('id');
        $table->string('email')->unique();
        $table->string('password', 60);
        $table->string('first_name')->nullable()->default(null);
        $table->string('last_name')->nullable()->default(null);
        $table->string('display_name')->nullable()->default(null);
        $table->string('avatar_img')->nullable()->default(null);
        $table->string('cover_image')->nullable()->default(null);
        $table->string('slug')->nullable()->default(null);
        $table->string('website')->nullable()->default(NULL);
        $table->string('country')->nullable()->default(NULL);
        $table->string('gravatar')->nullable()->default(NULL);
        $table->text('bio')->nullable()->default(NULL);
        $table->string('location')->nullable()->default(NULL);
        $table->decimal('latitude', 9, 2);
        $table->decimal('longitude', 9, 2);
        $table->string('imagefile')->nullable()->default(NULL);
        $table->char('fb_url', 100)->default(NULL)->nullable()->default(NULL);
  			$table->char('twitter', 100)->default(NULL)->nullable()->default(NULL);
  			$table->char('pinterest', 100)->default(NULL)->nullable()->default(NULL);
  			$table->char('google', 100)->default(NULL)->nullable()->default(NULL);
  			$table->char('youtube', 100)->default(NULL)->nullable()->default(NULL);
        $table->boolean('post_to_fb')->default(1);
        $table->boolean('fave_to_fb')->default(1);
        $table->rememberToken();
        $table->timestamps();
        $table->softDeletes();
      });

      /*
      * Create social login table
      */
      Schema::create('social', function(Blueprint $table)
      {
        $table->engine = 'InnoDB';
        $table->increments('id');
        $table->integer('user_id');
        $table->string('service');
        $table->string('uid')->nullable()->default(NULL);
        $table->timestamps();
        $table->string('access_token')->default(NULL)->nullable()->default(NULL);
        $table->integer('end_of_life')->default(NULL)->nullable()->default(NULL);
        $table->string('refresh_token')->default(NULL)->nullable()->default(NULL);
        $table->string('request_token')->default(NULL)->nullable()->default(NULL);
        $table->string('request_token_secret')->default(NULL)->nullable()->default(NULL);
        $table->text('extra_params')->default(NULL)->nullable()->default(NULL);
        $table->string('access_token_secret')->default(NULL)->nullable()->default(NULL);
      });

      /*
      * Create password resets table
      */

      Schema::create('password_resets', function (Blueprint $table)
      {
        $table->engine = 'InnoDB';
        $table->string('email')->index();
        $table->string('token')->index();
        $table->timestamp('created_at');
      });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('social');
    }
}
