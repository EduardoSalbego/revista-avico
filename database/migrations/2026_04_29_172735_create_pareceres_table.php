<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePareceresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pareceres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submissao_id')->constrained('submissoes')->cascadeOnDelete();
            $table->foreignId('revisor_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('aceito_tarefa')->nullable()->default(null);

            $table->enum('decisao', [
                'aceito',
                'rejeitado',
                'major_review',
                'revisao_pontual',
            ])->nullable();

            $table->text('comentario')->nullable();

            $table->unique(['submissao_id', 'revisor_id']);

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
        Schema::dropIfExists('pareceres');
    }
}
