<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuriculumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curiculums', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("KL_Tahun_Kurikulum");
            $table->boolean("KL_IsActive");
            $table->date("KL_Date_Start");
            $table->date("KL_Date_End");
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
        Schema::dropIfExists('curiculums');
    }
}
