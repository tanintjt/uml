<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spec_details', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('vehicle_id')->unsigned();
            $table->integer('cat_id')->unsigned();
            $table->string('title')->nullable();
            $table->string('spec_value')->nullable();

            $table->foreign('vehicle_id')->references('id')->on('vehicle')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('cat_id')->references('id')->on('spec_category')
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
        Schema::dropIfExists('spec_details');
    }
}
