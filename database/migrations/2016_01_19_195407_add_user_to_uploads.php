<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserToUploads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::table('entries_media', function ($table) {
         $table->integer('user_id')->nullable()->default(NULL);
         $table->text('upload_key')->nullable()->default(NULL);
       });
       Schema::rename('entries_media', 'media');
     }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::rename('media', 'entries_media');
      Schema::table('entries_media', function ($table) {
         $table->dropColumn(['user_id','upload_key']);
      });

    }
}
