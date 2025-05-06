<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Revista extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revistas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('editor_id');
            $table->unsignedBigInteger('area_id');
            $table->string('tituloRevista')->unique();
            $table->integer('limiteArtigo');
            $table->string('ISSNRevista')->unique();
            $table->unsignedBigInteger('periodicidade_id');

            $table->foreign('periodicidade_id')->references('id')->on('periodicidades')->onDelete('cascade');
            $table->foreign('editor_id')->references('id')->on('editors')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('revista');
    }
}