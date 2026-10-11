<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    protected $table = 'agendamentos';

    protected $fillable = [
        'foto_perfil',
        'nome_cliente',
        'idade_cliente',
        'telefone',
        'email',
        'imagem_tatuagem',
        'descricao_tatuagem',
        'local_corpo',
        'tamanho',
        'data_agendamento',
        'hora_agendamento',
        'valor_estimado',
        'forma_pagamento',
        'parcelas',
        'status',
        'observacoes',
        'funcionario_id',
    ];

    protected $casts = [
        'data_agendamento' => 'date',
        'valor_estimado' => 'decimal:2',
    ];

    /**
     * Relacionamento com funcionário (tatuador).
     */
    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

    /**
     * Relacionamento com galeria.
     */
    public function galeria()
    {
        return $this->hasOne(Galeria::class);
    }

    /**
     * Label da forma de pagamento.
     */
    public function getFormaPagamentoLabelAttribute()
    {
        $labels = [
            'dinheiro'        => 'Dinheiro',
            'cartao_credito'  => 'Cartão de Crédito',
            'cartao_debito'   => 'Cartão de Débito',
            'pix'             => 'PIX',
            'transferencia'   => 'Transferência Bancária',
        ];
        return $labels[$this->forma_pagamento] ?? $this->forma_pagamento;
    }

    /**
     * Label do status.
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pendente'   => 'Pendente',
            'confirmado' => 'Confirmado',
            'concluido'  => 'Concluído',
            'cancelado'  => 'Cancelado',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Cor do badge de status.
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'pendente'   => 'yellow',
            'confirmado' => 'blue',
            'concluido'  => 'green',
            'cancelado'  => 'red',
        ];
        return $colors[$this->status] ?? 'gray';
    }

    /**
     * URL da imagem da tatuagem.
     */
    public function getImagemTatuagemUrlAttribute()
    {
        if ($this->imagem_tatuagem) {
            return asset('storage/' . $this->imagem_tatuagem);
        }
        return null;
    }

    /**
     * URL da foto de perfil do cliente.
     */
    public function getFotoPerfilUrlAttribute()
    {
        if ($this->foto_perfil) {
            return asset('storage/' . $this->foto_perfil);
        }
        return asset('images/default-avatar.svg');
    }
}
