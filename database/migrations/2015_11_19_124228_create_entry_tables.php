<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntryTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


	    Schema::create('entries', function($table) {
        $table->engine = 'InnoDB';
        $table->increments('id')->unsigned();
        $table->string('title', 255);
        $table->text('description')->nullable();
        $table->enum('post_type', array('want','have','whut'));
        $table->string('location', 255);
        $table->decimal('latitude', 9,2)->nullable();
        $table->decimal('longitude', 9,2)->nullable();
        $table->integer('created_by');
        $table->boolean('enabled')->default("1");
        $table->boolean('visible');
        $table->timestamp('created_at')->nullable()->default(NULL);
        $table->timestamp('updated_at')->nullable()->default(NULL);
        $table->timestamp('deleted_at')->nullable();
        $table->string('tags', 250)->nullable();
        $table->dateTime('expires')->nullable();
        $table->dateTime('completed_at')->nullable();

      });


	    Schema::create('entries_exchange_types', function($table) {
        $table->engine = 'InnoDB';
        $table->increments('id');
        $table->integer('type_id');
        $table->integer('entry_id');
      });



	    Schema::create('entries_community_join', function($table) {
        $table->engine = 'InnoDB';
        $table->increments('id');
        $table->integer('community_id')->nullable();
        $table->integer('entry_id')->nullable();
        $table->timestamp('created_at')->nullable()->default(NULL);
        $table->timestamp('updated_at')->nullable()->default(NULL);
      });



      Schema::create('exchange_types', function($table)
      {
        $table->engine = 'InnoDB';
        $table->increments('id');
        $table->string('name', 255);
      });


	    Schema::create('entries_media', function($table)
      {
        $table->engine = 'InnoDB';
        $table->increments('id')->unsigned();
        $table->integer('entry_id')->nullable();
        $table->string('filename', 50)->nullable();
        $table->string('filetype', 5)->nullable();
        $table->string('caption', 200)->nullable();
        $table->timestamp('created_at')->nullable()->default(NULL);
        $table->timestamp('updated_at')->nullable()->default(NULL);
      });

      /**
	     * Table: messages
	     */
	    Schema::create('messages', function($table) {
        $table->engine = 'InnoDB';
        $table->increments('id')->unsigned();
        $table->integer('entry_id');
        $table->integer('sent_to');
        $table->integer('sent_by');
        $table->text('message')->nullable();
        $table->timestamps();
        $table->dateTime('read_on')->nullable();
      });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entries_exchange_types');
        Schema::dropIfExists('entries_exchange_types');
        Schema::dropIfExists('exchange_types');
        Schema::dropIfExists('entries_media');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('entries_community_join');

    }
}
