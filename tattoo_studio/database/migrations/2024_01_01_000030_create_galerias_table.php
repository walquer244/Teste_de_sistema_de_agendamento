<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galerias', function (Blueprint $table) {
            $table->id();
            $table->string('nome_cliente');
            $table->string('foto_perfil_cliente')->nullable(); // Foto de perfil do cliente na galeria
            $table->string('imagem_tatuagem'); // Imagem da tatuagem concluída
            $table->enum('estilo_tatuagem', [
                'realismo',
                'blackwork',
                'aquarela',
                'old_school',
                'new_school',
                'geometrico',
                'minimalista',
                'tribal',
                'japones',
                'dotwork',
                'fineline',
                'trash_polka',
                'neotradicional',
                'lettering',
                'outro'
            ]);
            $table->integer('avaliacao_atendimento')->default(5); // 1 a 5 estrelas
            $table->integer('avaliacao_resultado')->default(5); // 1 a 5 estrelas
            $table->text('comentario')->nullable();
            $table->boolean('destaque')->default(false); // Para destacar no portfólio
            // FK com funcionarios (tatuador que fez)
            $table->foreignId('funcionario_id')->constrained('funcionarios')->onDelete('cascade');
            // FK opcional com agendamento original
            $table->foreignId('agendamento_id')->nullable()->constrained('agendamentos')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galerias');
    }
};
