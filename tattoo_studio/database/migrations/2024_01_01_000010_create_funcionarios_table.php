<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->string('foto_perfil')->nullable();
            $table->string('nome');
            $table->integer('idade');
            $table->date('data_admissao');
            $table->decimal('salario', 10, 2);
            $table->enum('funcao', ['tatuador', 'atendente', 'gerente', 'auxiliar', 'recepcionista']);
            $table->string('especialidade')->nullable(); // Estilo de tatuagem (para tatuadores)
            $table->text('bio')->nullable();
            $table->string('instagram')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};
