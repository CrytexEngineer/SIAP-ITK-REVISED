<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->bigIncrements('KE_ID');
            $table->string('KE_KR_MK_ID')->unique();
//            $table->foreign('KE_KR_MK_ID')->references('MK_ID')->on('subjects')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('KE_Tahun');
            $table->integer('KE_IDSemester');
            $table->string('KE_Kelas');
            $table->integer('KE_DayaTampung');
            $table->bigInteger('KE_PE_NIPPengajar')->unsigned();
            $table->foreign('KE_PE_NIPPengajar')->references('PE_Nip')->on('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('KE_Terisi');
            $table->integer('KE_Jadwal_IDHari');
            $table->time('KE_Jadwal_JamMulai');
            $table->time('KE_Jadwal_JamUsai');
            $table->string('KE_Jadwal_Ruangan');
            $table->integer('KE_KodeJurusan')->unsigned();
            $table->foreign('KE_KodeJurusan')->references('PS_Kode_Prodi')->on('majors')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('KE_RencanaTatapMuka')->unsigned();
            $table->integer('KE_RealisasiTatapMuka')->unsigned();
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
        Schema::dropIfExists('classes');
    }
}
