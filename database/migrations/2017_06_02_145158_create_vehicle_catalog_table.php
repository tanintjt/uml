<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleCatalogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_catalog', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vehicle_type')->unsigned();
            $table->integer('vehicle_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->integer('vehicle_model')->unsigned();
            $table->string('vehicle_image', 255)->nullable();
            $table->timestamps();

            if(Schema::hasTable('brands'))
            {
                $table->foreign('brand_id')->references('id')->on('brands')
                    ->onUpdate('cascade')->onDelete('cascade');
            }

            if(Schema::hasTable('vehicle'))
            {
                $table->foreign('vehicle_id')->references('id')->on('vehicle')
                    ->onUpdate('cascade')->onDelete('cascade');
            }

            if(Schema::hasTable('vehicle_type'))
            {
                $table->foreign('vehicle_type')->references('id')->on('vehicle_type')
                    ->onUpdate('cascade')->onDelete('cascade');
            }

            if(Schema::hasTable('vehicle_model'))
            {
                $table->foreign('vehicle_model')->references('id')->on('vehicle_model')
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
           Schema::dropIfExists('vehicle_catalog');
       }
}



