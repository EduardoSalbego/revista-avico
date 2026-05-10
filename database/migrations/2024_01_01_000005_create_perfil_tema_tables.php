<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('autor_tema', function (Blueprint $table) {
            $table->foreignId('autor_id')->constrained('autores')->cascadeOnDelete();
            $table->foreignId('tema_id')->constrained('temas')->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->primary(['autor_id', 'tema_id']);
        });
        Schema::create('revisor_tema', function (Blueprint $table) {
            $table->foreignId('revisor_id')->constrained('revisores')->cascadeOnDelete();
            $table->foreignId('tema_id')->constrained('temas')->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->primary(['revisor_id', 'tema_id']);
        });
        Schema::create('leitor_tema', function (Blueprint $table) {
            $table->foreignId('leitor_id')->constrained('leitores')->cascadeOnDelete();
            $table->foreignId('tema_id')->constrained('temas')->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->primary(['leitor_id', 'tema_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('leitor_tema');
        Schema::dropIfExists('revisor_tema');
        Schema::dropIfExists('autor_tema');
    }
};
