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
            $table->bigInteger('PE_Nip')->unsigned()->primary();
            $table->string('PE_Email')->nullable();
            $table->String('PE_NamaLengkap');
            $table->String('PE_Nama');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('PE_KodeJurusan')->unsigned()->nullable();
            $table->foreign('PE_KodeJurusan')->references('PS_Kode_Prodi')->on('majors')->onUpdate('cascade')->onDelete('cascade');
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
