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
            $table->string('vehicle_type',255)->nullable();
            $table->integer('vehicle_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->string('vehicle_model',255)->nullable();
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



