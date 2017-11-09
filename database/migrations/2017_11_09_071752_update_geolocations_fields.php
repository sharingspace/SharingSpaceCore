<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGeolocationsFields extends Migration
{
    protected $models = [
        'App\Models\Entry',
        'App\Models\Community',
        'App\Models\User',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        collect($this->models)->each(function ($model) {
            $this->schemaUp($model);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        collect($this->models)->each(function ($model) {
            $this->schemaDown($model);
        });
    }

    protected function schemaUp($model)
    {
        $tableName = (new $model)->getTable();

        Schema::table($tableName, function (Blueprint $table) {
            $table->decimal('lat', 10, 8)->nullable()->default(null);
            $table->decimal('lng', 11, 8)->nullable()->default(null);
        });

        $model::all()->each(function ($item) {
            $item->lat = $item->latitude;
            $item->lng = $item->longitude;
            $item->save();
        });

        Schema::table($tableName, function (Blueprint $table) {
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });
    }

    protected function schemaDown($model)
    {
        $tableName = (new $model)->getTable();

        Schema::table($tableName, function (Blueprint $table) {
            $table->decimal('lat', 9, 2)->nullable()->default(null);
            $table->decimal('lng', 9, 2)->nullable()->default(null);
        });

        $model::all()->each(function ($item) {
            $item->latitude = $item->lat;
            $item->longitude = $item->lng;
            $item->save();
        });

        Schema::table($tableName, function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('lng');
        });
    }
}
