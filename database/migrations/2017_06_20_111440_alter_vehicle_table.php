<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicles', function($table)
        {
            $table->integer('brand_id')->unsigned()->after('id')->default(0);
            $table->string('vehicle_image', 256)->nullable()->after('fuel_system');

            if(Schema::hasTable('brands'))
            {
                $table->foreign('brand_id')->references('id')->on('brands')
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
        Schema::dropIfExists('vehicles');
    }
}
