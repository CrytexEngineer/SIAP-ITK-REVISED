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
            $table->bigIncrements('id')->unsigned();
            $table->integer('KU_KE_Tahun');
            $table->bigInteger('KU_MA_Nrp')->unsigned();
            $table->string('KU_KE_KR_MK_ID');
            $table->string('KU_KE_Kelas');
            $table->bigInteger('KU_KE_KodeJurusan')->unsigned();
            $table->foreign('KU_MA_Nrp')->references('MA_Nrp')->on('students')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('KU_KE_KR_MK_ID')->references('KE_KR_MK_ID')->on('classes')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('class_student');
    }
}
