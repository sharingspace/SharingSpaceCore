<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllowedExchangeTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      Schema::create('community_allowed_types', function($table) {
        $table->engine = 'InnoDB';
        $table->integer('community_id')->nullable();
        $table->integer('type_id')->nullable();
        $table->timestamp('created_at')->nullable()->default(NULL);
        $table->timestamp('updated_at')->nullable()->default(NULL);
      });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('community_allowed_types');
    }
}
