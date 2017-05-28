<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceCenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_center', function (Blueprint $table) {
            $table->increments('id');
            $table->double('latitude', 19, 16)->default(0);
            $table->double('longitude', 19, 16)->default(0);
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('store_image', 255)->nullable();
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
        Schema::dropIfExists('service_center');
    }
}
