<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type',255)->nullable();
            $table->string('model',255)->nullable();
            $table->string('production_year', 64)->nullable();
            $table->integer('engine_displacement')->nullable();
            $table->text('engine_details', 255)->nullable();
            $table->string('fuel_system',255)->nullable();

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
        Schema::dropIfExists('vehicle');
    }
}
