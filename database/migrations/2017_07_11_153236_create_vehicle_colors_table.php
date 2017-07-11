<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('vehicle_colors', function (Blueprint $table) {
            $table->integer('vehicle_id')->unsigned();
            $table->string('available_colors', 256)->nullable();

            $table->foreign('vehicle_id')->references('id')->on('vehicle')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['vehicle_id']);
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
        Schema::dropIfExists('vehicle_colors');
    }
}
