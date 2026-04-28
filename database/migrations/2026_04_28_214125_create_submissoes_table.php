<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // autor
            $table->string('titulo');
            $table->text('resumo');
            $table->text('cover_letter');
            $table->string('arquivo_pdf');
            $table->string('arquivo_docx')->nullable();
            $table->enum('status', [
                'submetido',
                'em_revisao',
                'aceito',
                'rejeitado',
            ])->default('submetido');
            $table->text('observacoes')->nullable();
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
        Schema::dropIfExists('submissoes');
    }
}
