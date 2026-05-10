<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('revisores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->enum('status', ['ativo', 'pendente', 'recusado'])->default('pendente');
            $table->string('lattes_url')->nullable();
            $table->string('orcid')->nullable();
            $table->string('titulacao')->nullable();
            $table->string('instituicao')->nullable();
            $table->integer('max_pareceres_simultaneos')->default(3);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('revisores');
    }
};
