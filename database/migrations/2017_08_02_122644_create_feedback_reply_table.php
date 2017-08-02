<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackReplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('feedback_reply', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('feedback_id')->unsigned();
            $table->string('reply_message', 255)->nullable();
            $table->integer('user_id')->unsigned(); //replied_by.....

            $table->foreign('feedback_id')->references('id')->on('feedback')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('feedback_reply');
    }
}
