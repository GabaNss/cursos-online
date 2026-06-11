<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao');
            $table->integer('carga_horaria');
            $table->enum('nivel', ['Iniciante', 'Intermediário', 'Avançado']);
            $table->decimal('preco', 8, 2);
            $table->string('imagem')->nullable();
            $table->enum('status', ['Ativo', 'Inativo', 'Em breve'])->default('Ativo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
