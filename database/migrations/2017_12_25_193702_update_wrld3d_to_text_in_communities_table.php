<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateWrld3dToTextInCommunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->dropColumn('wrld3d');
        });

        Schema::table('communities', function (Blueprint $table) {
            $table->text('wrld3d')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->dropColumn('wrld3d');
        });

        Schema::table('communities', function (Blueprint $table) {
            $table->string('wrld3d')->nullable();
        });
    }
}
