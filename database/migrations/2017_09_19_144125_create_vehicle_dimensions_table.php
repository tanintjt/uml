<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleDimensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_dimensions', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('vehicle_id')->unsigned();
            $table->string('length')->nullable();
            $table->string('width_with_side')->nullable();
            $table->string('width_without_side')->nullable();
            $table->string('height')->nullable();
            $table->string('tread_front')->nullable();
            $table->string('tread_rear')->nullable();
            $table->string('wheelbase')->nullable();
            $table->string('ground_clearance')->nullable();
            $table->float('turning_radius', 2, 1);

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
        Schema::dropIfExists('vehicle_dimensions');
    }
}
