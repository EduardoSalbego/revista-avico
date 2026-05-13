<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEdicoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edicoes', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('organizador');
            $table->string('imagem_capa');
            $table->text('resumo')->nullable();
            $table->enum('tipo_acesso', ['publica', 'exclusiva'])->default('publica');
            $table->boolean('permitir_comentarios')->default(true);
            $table->enum('status', ['rascunho', 'publicado'])->default('rascunho');
            $table->timestamp('data_publicacao')->nullable();
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
