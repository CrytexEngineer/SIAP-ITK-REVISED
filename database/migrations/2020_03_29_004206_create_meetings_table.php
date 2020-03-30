<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->bigIncrements('PT_ID')->unsigned();
            $table->timestamps();
            $table->bigInteger('PT_KE_ID')->unsigned();
            $table->foreign('PT_KE_ID')->references('id')->on('classes')->onUpdate('cascade')->onDelete('cascade');
            $table->string('PT_Token');
            $table->string('PT_isLate');
            $table->time('PT_LateTime');
            $table->time('PT_BlockTime');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meetings');
    }
}
