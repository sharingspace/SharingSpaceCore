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
        Schema::create('users', function (Blueprint $table) {
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
            $table->string('website')->nullable()->default(null);
            $table->string('country')->nullable()->default(null);
            $table->string('gravatar')->nullable()->default(null);
            $table->text('bio')->nullable()->default(null);
            $table->string('location')->nullable()->default(null);
            $table->decimal('latitude', 9, 2)->nullable()->default(null);
            $table->decimal('longitude', 9, 2)->nullable()->default(null);
            $table->string('imagefile')->nullable()->default(null);
            $table->char('fb_url', 100)->nullable()->default(null);
            $table->char('twitter', 100)->nullable()->default(null);
            $table->char('pinterest', 100)->nullable()->default(null);
            $table->char('google', 100)->nullable()->default(null);
            $table->char('youtube', 100)->nullable()->default(null);
            $table->boolean('post_to_fb')->default(1);
            $table->boolean('fave_to_fb')->default(1);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        /*
        * Create social login table
        */
        Schema::create('social', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->string('service');
            $table->string('uid')->nullable()->default(null);
            $table->timestamps();
            $table->string('access_token')->nullable()->default(null);
            $table->integer('end_of_life')->nullable()->default(null);
            $table->string('refresh_token')->nullable()->default(null);
            $table->string('request_token')->nullable()->default(null);
            $table->string('request_token_secret')->nullable()->default(null);
            $table->text('extra_params')->nullable()->default(null);
            $table->string('access_token_secret')->nullable()->default(null);
        });

        /*
        * Create password resets table
        */

        Schema::create('password_resets', function (Blueprint $table) {
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
