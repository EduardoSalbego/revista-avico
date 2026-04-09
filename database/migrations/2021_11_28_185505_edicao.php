<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Edicao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edicoes', function (Blueprint $table) {
            $table->string('titulo');
            $table->string('autor');
            $table->string('imagem_capa');
            $table->enum('tipo_conteudo', ['blocos', 'pdf']);
            $table->string('arquivo_pdf')->nullable();
            $table->json('conteudo_blocos')->nullable();
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
        Schema::dropIfExists('edicoes');
    }
}
