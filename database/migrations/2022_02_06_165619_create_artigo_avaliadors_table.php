<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtigoAvaliadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artigoavaliador', function (Blueprint $table) {
            $table->unsignedBigInteger('avaliador_id');
            $table->unsignedBigInteger('artigo_id');
            $table->timestamps();


            $table->foreign('avaliador_id')->references('id')->on('avaliadors')->onDelete('cascade');
            $table->foreign('artigo_id')->references('id')->on('artigos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artigo_avaliadors');
    }
}
