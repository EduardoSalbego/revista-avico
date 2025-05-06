<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubmissaoArtigo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SubmissaoArtigo', function (Blueprint $table) {
            $table->bigInteger('submissao_id')->unsigned();        
            $table->bigInteger('artigo_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('submissao_id')->references('id')->on('Submissao')->onDelete('cascade');
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
        Schema::dropIfExists('SubmissaoArtigo');
    }
}
