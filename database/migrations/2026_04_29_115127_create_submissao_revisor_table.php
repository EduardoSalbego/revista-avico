<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissaoRevisorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissao_revisor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submissao_id')->constrained('submissoes')->cascadeOnDelete();
            $table->foreignId('revisor_id')->constrained('users')->cascadeOnDelete();
            $table->string('status')->default('pendente');
            $table->timestamp('ultima_notificacao_em')->nullable();
            $table->timestamp('atribuido_em')->useCurrent();
            $table->timestamps();
            $table->unique(['submissao_id', 'revisor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submissao_revisor');
    }
}
