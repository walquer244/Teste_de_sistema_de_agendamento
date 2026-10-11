<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $table = 'funcionarios';

    protected $fillable = [
        'foto_perfil',
        'nome',
        'idade',
        'data_admissao',
        'salario',
        'funcao',
        'especialidade',
        'bio',
        'instagram',
        'ativo',
    ];

    protected $casts = [
        'data_admissao' => 'date',
        'salario' => 'decimal:2',
        'ativo' => 'boolean',
    ];

    /**
     * Retorna apenas os tatuadores ativos.
     */
    public function scopeTatuadores($query)
    {
        return $query->where('funcao', 'tatuador')->where('ativo', true);
    }

    /**
     * Relacionamento com agendamentos.
     */
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }

    /**
     * Relacionamento com galeria.
     */
    public function galerias()
    {
        return $this->hasMany(Galeria::class);
    }

    /**
     * Total de serviços realizados.
     */
    public function totalServicos()
    {
        return $this->agendamentos()->where('status', 'concluido')->count();
    }

    /**
     * Média de avaliação de atendimento na galeria.
     */
    public function mediaAvaliacaoAtendimento()
    {
        return $this->galerias()->avg('avaliacao_atendimento') ?? 0;
    }

    /**
     * Média de avaliação de resultado na galeria.
     */
    public function mediaAvaliacaoResultado()
    {
        return $this->galerias()->avg('avaliacao_resultado') ?? 0;
    }

    /**
     * URL da foto de perfil.
     */
    public function getFotoPerfilUrlAttribute()
    {
        if ($this->foto_perfil) {
            return asset('storage/' . $this->foto_perfil);
        }
        return asset('images/default-avatar.svg');
    }

    /**
     * Nome formatado da função.
     */
    public function getFuncaoLabelAttribute()
    {
        $labels = [
            'tatuador'     => 'Tatuador(a)',
            'atendente'    => 'Atendente',
            'gerente'      => 'Gerente',
            'auxiliar'     => 'Auxiliar',
            'recepcionista'=> 'Recepcionista',
        ];
        return $labels[$this->funcao] ?? $this->funcao;
    }
}
