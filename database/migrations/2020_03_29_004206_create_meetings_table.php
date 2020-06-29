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
            $table->integer('PT_Urutan')->unsigned();
            $table->string('PT_Name');
            $table->string('PT_Type');
            $table->string('PT_Notes');
            $table->foreign('PT_KE_ID')->references('KE_ID')->on('classes')->onUpdate('cascade')->onDelete('cascade');
            $table->string('PT_Token')->unique();
            $table->string('PT_isLate');
            $table->dateTime('PT_LateTime')->useCurrent();
            $table->dateTime('PT_BlockTime')->useCurrent();

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
