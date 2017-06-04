<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doc_type_id')->unsigned();
            $table->dateTime('issue_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->binary('file')->nullable();
            $table->timestamps();

            if(Schema::hasTable('e_doc_type'))
            {
                $table->foreign('doc_type_id')->references('id')->on('e_doc_type')
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
        Schema::dropIfExists('e_documents');
    }
}
