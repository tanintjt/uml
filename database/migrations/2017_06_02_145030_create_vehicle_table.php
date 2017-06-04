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
            $table->integer('type_id')->unsigned();
            $table->integer('model_id')->unsigned();
            $table->string('production_year', 64)->nullable();
            $table->integer('engine_displacement')->nullable();
            $table->text('engine_details', 255)->nullable();
            $table->string('fuel_system',255)->nullable();

            $table->timestamps();

            if(Schema::hasTable('vehicle_type'))
            {
                $table->foreign('type_id')->references('id')->on('vehicle_type')
                    ->onUpdate('cascade')->onDelete('cascade');
            }

            if(Schema::hasTable('vehicle_model'))
            {
                $table->foreign('model_id')->references('id')->on('vehicle_model')
                    ->onUpdate('cascade')->onDelete('cascade');
            }

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
