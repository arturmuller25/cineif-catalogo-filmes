<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela de filmes.
     */
    public function up(): void
    {
        Schema::create('filmes', function (Blueprint $table) {
            $table->id();

            // Chave estrangeira: usuário que cadastrou o filme.
            $table->foreignId('usuario_id')->constrained('users')->cascadeOnDelete();

            // Chave estrangeira: categoria a que o filme pertence.
            $table->foreignId('categoria_id')->constrained('categorias')->cascadeOnDelete();

            $table->string('titulo');
            $table->text('sinopse');
            $table->unsignedSmallInteger('ano');
            $table->string('imagem_capa')->nullable();
            $table->string('trailer_url')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filmes');
    }
};
