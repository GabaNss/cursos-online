<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscricoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->string('aluno');
            $table->string('email')->nullable();
            $table->date('data_inscricao');
            $table->enum('status', ['Pendente', 'Confirmada', 'Cancelada'])->default('Pendente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscricoes');
    }
};
