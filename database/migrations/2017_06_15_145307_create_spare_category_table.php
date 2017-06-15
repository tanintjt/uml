<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpareCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sp_cat_id')->unsigned();
            $table->integer('sp_id')->unsigned();
            $table->timestamps();


            if(Schema::hasTable('spare_parts_category'))
            {
                $table->foreign('sp_cat_id')->references('id')->on('spare_parts_category')
                    ->onUpdate('cascade')->onDelete('cascade');
            }

            if(Schema::hasTable('spare_parts'))
            {
                $table->foreign('sp_id')->references('id')->on('spare_parts')
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
        Schema::dropIfExists('spare_category');
    }
}
