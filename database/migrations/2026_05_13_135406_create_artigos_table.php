<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtigosTable extends Migration
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
            $table->foreignId('edicao_id')->nullable()->constrained('edicoes')->onDelete('cascade');
            $table->foreignId('autor_id')->nullable()->constrained('autores')->onDelete('cascade');
            $table->foreignId('submissao_id')->constrained('submissoes')->onDelete('cascade');
            $table->string('titulo');
            $table->text('resumo');
            $table->string('arquivo_pdf')->nullable();
            $table->integer('ordem')->default(1);

            $table->string('doi')->nullable();
            $table->string('palavras_chave')->nullable();
            $table->text('referencias')->nullable();

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
        Schema::dropIfExists('artigos');
    }
}
