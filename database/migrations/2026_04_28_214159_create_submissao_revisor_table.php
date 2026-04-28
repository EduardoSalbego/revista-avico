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
            $table->foreignId('submissao_id')->constrained('submissoes')->cascadeOnDelete();
            $table->foreignId('revisor_id')->constrained('users')->cascadeOnDelete();
            $table->primary(['submissao_id', 'revisor_id']);
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
