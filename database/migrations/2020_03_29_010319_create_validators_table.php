<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validators', function (Blueprint $table) {
            $table->bigIncrements('VD_ID');
            $table->timestamps();
            $table->bigInteger('VD_PT_ID')->unsigned();
            $table->foreign('VD_PT_ID')->references('PT_ID')->on('meetings') -> onUpdate('cascade')->onDelete('cascade');
            $table->string('VD_Token');
            $table->dateTime('VD_Expired');
        });}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('validators');
    }
    }
