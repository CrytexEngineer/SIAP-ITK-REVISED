<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presences', function (Blueprint $table) {
            $table->bigIncrements('PR_ID');
            $table->bigInteger('KU_ID')->unsigned();
            $table->foreign('KU_ID')->references('id')->on('class_student')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('KE_ID')->unsigned();
            $table->foreign('KE_ID')->references('id')->on('classes')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('presences');
    }
}
