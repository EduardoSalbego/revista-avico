<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArtigoFinal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('artigos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('situacao_id');
            $table->string('tituloArtigo');
            $table->string('caminhoArtigo');
            $table->unsignedBigInteger('edicao_id')->nullable();
            $table->timestamps();

            $table->foreign('situacao_id')->references('id')->on('situacao')->onDelete('cascade');
            $table->foreign('edicao_id')->references('id')->on('edicoes')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autors');
    }
}
