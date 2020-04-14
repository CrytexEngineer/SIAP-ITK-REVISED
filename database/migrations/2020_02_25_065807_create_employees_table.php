<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
//            $table->bigInteger('PE_Nip')->unsigned()->primary();
//            $table->string('PE_Email')->unique()->nullable();
//            $table->String('PE_NamaLengkap');
//            $table->String('PE_Nama');
//            $table->integer('PE_TipePegawai')->unsigned();
//            $table->timestamps();

//            $table->bigIncrements('id');
            $table->bigInteger('PE_Nip')->unsigned()->primary();
            $table->string('PE_Email')->unique()->nullable();
            $table->string('PE_NamaLengkap');
            $table->string('PE_Nama');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('employees');
    }
}
