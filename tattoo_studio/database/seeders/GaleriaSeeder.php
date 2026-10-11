<?php

namespace Database\Seeders;

use App\Models\Galeria;
use Illuminate\Database\Seeder;

class GaleriaSeeder extends Seeder
{
    public function run(): void
    {
        $galerias = [
            [
                'id'                    => 1,
                'nome_cliente'          => 'Larissa Souza',
                'imagem_tatuagem'       => '',
                'estilo_tatuagem'       => 'fineline',
                'avaliacao_atendimento' => 5,
                'avaliacao_resultado'   => 5,
                'comentario'            => 'Experiência impecável! A Camila tem a mão super leve e os traços ficaram absurdamente perfeitos.',
                'destaque'              => true,
                'funcionario_id'        => 2,
                'agendamento_id'        => 1,
            ],
            [
                'id'                    => 2,
                'nome_cliente'          => 'Gabriel Martins',
                'imagem_tatuagem'       => '',
                'estilo_tatuagem'       => 'realismo',
                'avaliacao_atendimento' => 5,
                'avaliacao_resultado'   => 5,
                'comentario'            => 'O Marcus é um gênio do realismo. Parece uma fotografia na minha pele! Super recomendo.',
                'destaque'              => true,
                'funcionario_id'        => 1,
                'agendamento_id'        => 2,
            ],
            [
                'id'                    => 3,
                'nome_cliente'          => 'Pedro Henrique',
                'imagem_tatuagem'       => '',
                'estilo_tatuagem'       => 'blackwork',
                'avaliacao_atendimento' => 5,
                'avaliacao_resultado'   => 5,
                'comentario'            => 'Trabalho de pretos sólidos impecável. O estúdio tem uma vibe incrível e biossegurança de ponta.',
                'destaque'              => true,
                'funcionario_id'        => 1,
                'agendamento_id'        => null,
            ],
            [
                'id'                    => 4,
                'nome_cliente'          => 'Mariana Costa',
                'imagem_tatuagem'       => '',
                'estilo_tatuagem'       => 'fineline',
                'avaliacao_atendimento' => 5,
                'avaliacao_resultado'   => 5,
                'comentario'            => 'Minha primeira tatuagem e foi maravilhoso. Traço fino e delicado exatamente como eu sonhava.',
                'destaque'              => false,
                'funcionario_id'        => 2,
                'agendamento_id'        => null,
            ],
            [
                'id'                    => 5,
                'nome_cliente'          => 'Eduardo Ramos',
                'imagem_tatuagem'       => '',
                'estilo_tatuagem'       => 'japones',
                'avaliacao_atendimento' => 5,
                'avaliacao_resultado'   => 5,
                'comentario'            => 'Diego é referência em estilo oriental. Cores vivas e contraste perfeito!',
                'destaque'              => true,
                'funcionario_id'        => 3,
                'agendamento_id'        => null,
            ],
            [
                'id'                    => 6,
                'nome_cliente'          => 'Carla Vieira',
                'imagem_tatuagem'       => '',
                'estilo_tatuagem'       => 'old_school',
                'avaliacao_atendimento' => 5,
                'avaliacao_resultado'   => 5,
                'comentario'            => 'Lucas mandou muito bem na composição tradicional! As cores ficaram intensas demais.',
                'destaque'              => false,
                'funcionario_id'        => 4,
                'agendamento_id'        => null,
            ],
        ];

        foreach ($galerias as $g) {
            Galeria::updateOrCreate(['id' => $g['id']], $g);
        }
    }
}
