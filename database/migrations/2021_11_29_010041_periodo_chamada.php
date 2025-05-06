<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PeriodoChamada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PeriodoChamada', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('revista_id');
            $table->date('dataInicio');   
            $table->date('dataFinal'); 
            $table->date('dataMaximaAvaliacao');      
            $table->date('dataDivulgacao'); 
           
            $table->foreign('revista_id')->references('id')->on('revistas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('PeriodoChamada');
    }
}
