<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        Schema::create('autors', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('orcid')->unique();
            $table->unsignedBigInteger('area_id');
            $table->string('instituicao');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('area_id')->references('id')->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autors');
    }
}
