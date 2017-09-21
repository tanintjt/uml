<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleBrakesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_brakes', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('vehicle_id')->unsigned();
            $table->string('front')->nullable();
            $table->string('rear')->nullable();

            $table->foreign('vehicle_id')->references('id')->on('vehicle')
                ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('vehicle_brakes');
    }
}
