<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGeoLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geo_location', function($table)
        {
            $table->increments('id')->comment('Unique identifier');
            $table->string('location_type', 255)->comment('Location type for instance Hospital,Hotel,etc')->nullable();
            $table->text('address')->comment('Address of location type');
            $table->decimal('latitude', 10, 8)->comment('Latitude of given location');
            $table->decimal('longitude', 11, 8)->comment('Longitude of give location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('geo_location');
    }
}
