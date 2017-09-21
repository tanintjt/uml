<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleEngineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_engine', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('vehicle_id')->unsigned();
            $table->integer('no_of_cylinders')->default(0);
            $table->integer('no_of_valves')->default(0);
            $table->string('swept_volume')->nullable();
            $table->string('engine_type')->nullable();
            $table->string('engine_control')->nullable();
            $table->string('max_power')->nullable();
            $table->string('max_torque')->nullable();
            $table->string('transmission')->nullable();

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
        Schema::dropIfExists('vehicle_engine');
    }
}
