<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FuncionarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Funcionario::withCount(['agendamentos', 'galerias']);

        if ($request->filled('busca')) {
            $query->where('nome', 'like', '%' . $request->busca . '%');
        }

        if ($request->filled('funcao')) {
            $query->where('funcao', $request->funcao);
        }

        if ($request->filled('status')) {
            $query->where('ativo', $request->status === 'ativo');
        }

        $funcionarios = $query->orderBy('nome')->paginate(10)->withQueryString();

        return view('funcionarios.index', compact('funcionarios'));
    }

    public function create()
    {
        return view('funcionarios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'           => 'required|string|max:255',
            'idade'          => 'required|integer|min:18|max:80',
            'data_admissao'  => 'required|date',
            'salario'        => 'required|numeric|min:0',
            'funcao'         => 'required|in:tatuador,atendente,gerente,auxiliar,recepcionista',
            'especialidade'  => 'nullable|string|max:255',
            'bio'            => 'nullable|string',
            'instagram'      => 'nullable|string|max:100',
            'foto_perfil'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'nome.required'          => 'O nome é obrigatório.',
            'idade.required'         => 'A idade é obrigatória.',
            'idade.min'              => 'A idade mínima é 18 anos.',
            'data_admissao.required' => 'A data de admissão é obrigatória.',
            'salario.required'       => 'O salário é obrigatório.',
            'funcao.required'        => 'A função é obrigatória.',
            'foto_perfil.image'      => 'O arquivo deve ser uma imagem.',
            'foto_perfil.max'        => 'A imagem não pode ultrapassar 5MB.',
        ]);

        if ($request->hasFile('foto_perfil')) {
            $validated['foto_perfil'] = $request->file('foto_perfil')->store('funcionarios/fotos', 'public');
        }

        $validated['ativo'] = $request->has('ativo') ? true : false;

        Funcionario::create($validated);

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionário cadastrado com sucesso!');
    }

    public function show(Funcionario $funcionario)
    {
        $funcionario->load([
            'agendamentos' => function ($q) {
                $q->orderBy('data_agendamento', 'desc')->take(10);
            },
            'galerias' => function ($q) {
                $q->orderBy('created_at', 'desc');
            },
        ]);

        $estatisticas = [
            'total_agendamentos'  => $funcionario->agendamentos()->count(),
            'agendamentos_concluidos' => $funcionario->agendamentos()->where('status', 'concluido')->count(),
            'agendamentos_pendentes'  => $funcionario->agendamentos()->where('status', 'pendente')->count(),
            'total_galeria'       => $funcionario->galerias()->count(),
            'receita_total'       => $funcionario->agendamentos()->where('status', 'concluido')->sum('valor_estimado'),
            'media_atendimento'   => round($funcionario->galerias()->avg('avaliacao_atendimento') ?? 0, 1),
            'media_resultado'     => round($funcionario->galerias()->avg('avaliacao_resultado') ?? 0, 1),
        ];

        return view('funcionarios.show', compact('funcionario', 'estatisticas'));
    }

    public function edit(Funcionario $funcionario)
    {
        return view('funcionarios.edit', compact('funcionario'));
    }

    public function update(Request $request, Funcionario $funcionario)
    {
        $validated = $request->validate([
            'nome'           => 'required|string|max:255',
            'idade'          => 'required|integer|min:18|max:80',
            'data_admissao'  => 'required|date',
            'salario'        => 'required|numeric|min:0',
            'funcao'         => 'required|in:tatuador,atendente,gerente,auxiliar,recepcionista',
            'especialidade'  => 'nullable|string|max:255',
            'bio'            => 'nullable|string',
            'instagram'      => 'nullable|string|max:100',
            'foto_perfil'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($request->hasFile('foto_perfil')) {
            // Remove foto anterior
            if ($funcionario->foto_perfil) {
                Storage::disk('public')->delete($funcionario->foto_perfil);
            }
            $validated['foto_perfil'] = $request->file('foto_perfil')->store('funcionarios/fotos', 'public');
        }

        $validated['ativo'] = $request->has('ativo') ? true : false;

        $funcionario->update($validated);

        return redirect()->route('funcionarios.show', $funcionario)
            ->with('success', 'Funcionário atualizado com sucesso!');
    }

    public function destroy(Funcionario $funcionario)
    {
        // Verifica se tem agendamentos pendentes/confirmados
        $agendamentosAtivos = $funcionario->agendamentos()
            ->whereIn('status', ['pendente', 'confirmado'])
            ->count();

        if ($agendamentosAtivos > 0) {
            return back()->with('error', 'Não é possível excluir um funcionário com agendamentos ativos. Cancele ou conclua os agendamentos primeiro.');
        }

        if ($funcionario->foto_perfil) {
            Storage::disk('public')->delete($funcionario->foto_perfil);
        }

        $funcionario->delete();

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionário removido com sucesso!');
    }
}
