<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogbookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logbooks', function (Blueprint $table) {
            $table->bigIncrements('LB_ID');
            $table->bigInteger('LB_PE_Nip')->unsigned();
            $table->foreign('LB_PE_Nip')->references('PE_Nip')->on('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->string('LB_Table');
            $table->string('LB_Notes');
            $table->string('LB_Action_ID');
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
        Schema::dropIfExists('logbooks');
    }
}
