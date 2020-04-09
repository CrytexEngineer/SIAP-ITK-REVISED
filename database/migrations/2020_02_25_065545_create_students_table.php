<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigInteger('MA_Nrp')->unsigned()->unique();
            $table->bigInteger('MA_NRP_Baru')->unsigned()->primary();
            $table->String('MA_NamaLengkap');
            $table->String('MA_Email')->nullable();
            $table->String('MA_IMEI')->nullable();
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
        Schema::dropIfExists('students');
    }
}
