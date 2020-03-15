<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesStudent extends Migration
{
 /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_student', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('MA_Nrp')->unsigned();
            $table->bigInteger('KE_ID')->unsigned();
            $table->foreign('MA_Nrp')->references('MA_Nrp')->on('students')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('KE_ID')->references('KE_ID')->on('classes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_student');
    }
}
