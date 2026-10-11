<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeria extends Model
{
    use HasFactory;

    protected $table = 'galerias';

    protected $fillable = [
        'nome_cliente',
        'foto_perfil_cliente',
        'imagem_tatuagem',
        'estilo_tatuagem',
        'avaliacao_atendimento',
        'avaliacao_resultado',
        'comentario',
        'destaque',
        'funcionario_id',
        'agendamento_id',
    ];

    protected $casts = [
        'destaque' => 'boolean',
        'avaliacao_atendimento' => 'integer',
        'avaliacao_resultado' => 'integer',
    ];

    /**
     * Relacionamento com funcionário (tatuador).
     */
    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

    /**
     * Relacionamento com agendamento original.
     */
    public function agendamento()
    {
        return $this->belongsTo(Agendamento::class);
    }

    /**
     * URL da imagem da tatuagem.
     */
    public function getImagemTatuagemUrlAttribute()
    {
        if ($this->imagem_tatuagem) {
            return asset('storage/' . $this->imagem_tatuagem);
        }
        return asset('images/default-tattoo.svg');
    }

    /**
     * URL da foto de perfil do cliente.
     */
    public function getFotoPerfilClienteUrlAttribute()
    {
        if ($this->foto_perfil_cliente) {
            return asset('storage/' . $this->foto_perfil_cliente);
        }
        return asset('images/default-avatar.svg');
    }

    /**
     * Label do estilo de tatuagem.
     */
    public function getEstiloLabelAttribute()
    {
        $labels = [
            'realismo'       => 'Realismo',
            'blackwork'      => 'Blackwork',
            'aquarela'       => 'Aquarela',
            'old_school'     => 'Old School',
            'new_school'     => 'New School',
            'geometrico'     => 'Geométrico',
            'minimalista'    => 'Minimalista',
            'tribal'         => 'Tribal',
            'japones'        => 'Japonês',
            'dotwork'        => 'Dotwork',
            'fineline'       => 'Fineline',
            'trash_polka'    => 'Trash Polka',
            'neotradicional' => 'Neotradicional',
            'lettering'      => 'Lettering',
            'outro'          => 'Outro',
        ];
        return $labels[$this->estilo_tatuagem] ?? $this->estilo_tatuagem;
    }

    /**
     * Media das avaliações.
     */
    public function getMediaAvaliacoesAttribute()
    {
        return round(($this->avaliacao_atendimento + $this->avaliacao_resultado) / 2, 1);
    }
}
