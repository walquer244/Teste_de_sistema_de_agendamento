<?php

namespace Database\Seeders;

use App\Models\Funcionario;
use Illuminate\Database\Seeder;

class FuncionarioSeeder extends Seeder
{
    public function run(): void
    {
        $funcionarios = [
            [
                'id'            => 1,
                'nome'          => 'Marcus Silva',
                'idade'         => 32,
                'data_admissao' => '2022-03-15',
                'salario'       => 6500.00,
                'funcao'        => 'tatuador',
                'especialidade' => 'Realismo & Blackwork',
                'bio'           => 'Especialista em retratos realistas em preto e cinza com mais de 8 anos de experiência internacional.',
                'instagram'     => '@marcus.tattoos',
                'ativo'         => true,
            ],
            [
                'id'            => 2,
                'nome'          => 'Camila Rossi',
                'idade'         => 28,
                'data_admissao' => '2022-07-01',
                'salario'       => 5800.00,
                'funcao'        => 'tatuador',
                'especialidade' => 'Fineline & Floral',
                'bio'           => 'Traços finos, microrealismo botânico e delicadeza em cada detalhe. Formada em Artes Visuais.',
                'instagram'     => '@camila.fineline',
                'ativo'         => true,
            ],
            [
                'id'            => 3,
                'nome'          => 'Diego Aoki',
                'idade'         => 35,
                'data_admissao' => '2021-11-10',
                'salario'       => 7200.00,
                'funcao'        => 'tatuador',
                'especialidade' => 'Oriental & Neo Tradicional',
                'bio'           => 'Mestre na tradição oriental e neo tradicional com cores vibrantes e anatomia precisa.',
                'instagram'     => '@diego.aoki.ink',
                'ativo'         => true,
            ],
            [
                'id'            => 4,
                'nome'          => 'Lucas Ferreira',
                'idade'         => 29,
                'data_admissao' => '2023-01-20',
                'salario'       => 5200.00,
                'funcao'        => 'tatuador',
                'especialidade' => 'Old School & Lettering',
                'bio'           => 'Apaixonado pela estética clássica americana, tipografias customizadas e traços sólidos.',
                'instagram'     => '@lucas.ferreira.art',
                'ativo'         => true,
            ],
            [
                'id'            => 5,
                'nome'          => 'Beatriz Mendes',
                'idade'         => 24,
                'data_admissao' => '2023-05-10',
                'salario'       => 2600.00,
                'funcao'        => 'recepcionista',
                'especialidade' => null,
                'bio'           => 'Responsável pelo atendimento aos clientes, recepção e agendamento de consultas e sessões.',
                'instagram'     => '@beatriz.mendes',
                'ativo'         => true,
            ],
            [
                'id'            => 6,
                'nome'          => 'Rodrigo Alcantara',
                'idade'         => 41,
                'data_admissao' => '2021-01-15',
                'salario'       => 5500.00,
                'funcao'        => 'gerente',
                'especialidade' => null,
                'bio'           => 'Gestor operacional do Ink Studio, cuidando da biossegurança, compras e suporte aos artistas.',
                'instagram'     => '@rodrigo.alcantara',
                'ativo'         => true,
            ],
        ];

        foreach ($funcionarios as $f) {
            Funcionario::updateOrCreate(['id' => $f['id']], $f);
        }
    }
}
