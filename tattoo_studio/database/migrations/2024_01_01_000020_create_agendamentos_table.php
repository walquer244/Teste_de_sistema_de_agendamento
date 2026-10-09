<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->string('foto_perfil')->nullable();
            $table->string('nome_cliente');
            $table->integer('idade_cliente');
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->string('imagem_tatuagem')->nullable(); // Imagem de referência ou arte final
            $table->text('descricao_tatuagem')->nullable();
            $table->string('local_corpo')->nullable(); // Onde vai fazer a tatuagem
            $table->string('tamanho')->nullable(); // Estimativa de tamanho
            $table->date('data_agendamento');
            $table->time('hora_agendamento');
            $table->decimal('valor_estimado', 10, 2)->nullable();
            $table->enum('forma_pagamento', ['dinheiro', 'cartao_credito', 'cartao_debito', 'pix', 'transferencia']);
            $table->integer('parcelas')->default(1);
            $table->enum('status', ['pendente', 'confirmado', 'concluido', 'cancelado'])->default('pendente');
            $table->text('observacoes')->nullable();
            // FK com funcionarios - apenas tatuadores
            $table->foreignId('funcionario_id')->constrained('funcionarios')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};
