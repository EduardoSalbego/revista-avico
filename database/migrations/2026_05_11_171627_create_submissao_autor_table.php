<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissaoAutorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissao_autor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submissao_id')->constrained('submissoes')->cascadeOnDelete();
            $table->string('nome', 255);
            $table->string('instituicao')->nullable();
            $table->boolean('autor_principal')->default(false);
            $table->integer('ordem')->nullable(); // 1º autor, 2º autor, etc.
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
        Schema::dropIfExists('submissao_autor');
    }
}
