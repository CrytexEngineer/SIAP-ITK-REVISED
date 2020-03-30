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
            $table->timestamps();
            $table->bigInteger('PR_PT_ID')->unsigned();
            $table->foreign('PR_PT_ID')->references('PT_ID')->on('meetings')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('PR_KU_ID')->unsigned();
            $table->foreign('PR_KU_ID')->references('id')->on('classes')->onUpdate('cascade')->onDelete('cascade');
      $table->string('PR_keterangan');
      $table->string("PR_isLAte");
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
