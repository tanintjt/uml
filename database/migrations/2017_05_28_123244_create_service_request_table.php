<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('service_center_id')->unsigned();
            $table->integer('service_package_id')->unsigned();
            $table->string('status')->nullable();
            $table->dateTime('request_time')->nullable();
            $table->text('special_request')->nullable();

            $table->timestamps();

            if(Schema::hasTable('users'))
            {
                $table->foreign('user_id')->references('id')->on('users')
                    ->onUpdate('cascade')->onDelete('cascade');
            }

            if(Schema::hasTable('service_center'))
            {
                $table->foreign('service_center_id')->references('id')->on('service_center')
                    ->onUpdate('cascade')->onDelete('cascade');
            }

            if(Schema::hasTable('service_package'))
            {
                $table->foreign('service_package_id')->references('id')->on('service_package')
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

    }
}
