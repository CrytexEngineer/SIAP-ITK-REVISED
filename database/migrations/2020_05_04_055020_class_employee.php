<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClassEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('class_employee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_PE_Nip')->unsigned();
            $table->foreign('employee_PE_Nip')->references('PE_Nip')->on('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('classes_KE_ID')->unsigned();
            $table->foreign('classes_KE_ID')->references('KE_ID')->on('classes')->onUpdate('cascade')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
