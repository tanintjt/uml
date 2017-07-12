<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSparePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_parts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('part_id',64);
            $table->decimal('rate', 5,2);
//            $table->integer('sp_cat_id')->unsigned();
            $table->timestamps();

//            if(Schema::hasTable('spare_parts_category'))
//            {
//                $table->foreign('sp_cat_id')->references('id')->on('spare_parts_category')
//                    ->onUpdate('cascade')->onDelete('cascade');
//            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spare_parts');
    }
}
