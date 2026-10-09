<?php

namespace App\Http\Controllers;

use App\Models\Galeria;
use App\Models\Funcionario;
use App\Models\Agendamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Galeria::with('funcionario');

        if ($request->filled('busca')) {
            $query->where('nome_cliente', 'like', '%' . $request->busca . '%');
        }

        if ($request->filled('estilo')) {
            $query->where('estilo_tatuagem', $request->estilo);
        }

        if ($request->filled('tatuador')) {
            $query->where('funcionario_id', $request->tatuador);
        }

        if ($request->filled('destaque')) {
            $query->where('destaque', true);
        }

        $galerias = $query->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        $tatuadores = Funcionario::tatuadores()->orderBy('nome')->get();

        $estilos = [
            'realismo', 'blackwork', 'aquarela', 'old_school', 'new_school',
            'geometrico', 'minimalista', 'tribal', 'japones', 'dotwork',
            'fineline', 'trash_polka', 'neotradicional', 'lettering', 'outro'
        ];

        return view('galerias.index', compact('galerias', 'tatuadores', 'estilos'));
    }

    public function create(Request $request)
    {
        $tatuadores = Funcionario::tatuadores()->orderBy('nome')->get();

        if ($tatuadores->isEmpty()) {
            return redirect()->route('galerias.index')
                ->with('error', 'Nenhum tatuador cadastrado.');
        }

        // Se veio de um agendamento concluído, pre-preenche os dados
        $agendamento = null;
        if ($request->filled('agendamento_id')) {
            $agendamento = Agendamento::with('funcionario')->find($request->agendamento_id);
        }

        return view('galerias.create', compact('tatuadores', 'agendamento'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome_cliente'         => 'required|string|max:255',
            'foto_perfil_cliente'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'imagem_tatuagem'      => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
            'estilo_tatuagem'      => 'required|in:realismo,blackwork,aquarela,old_school,new_school,geometrico,minimalista,tribal,japones,dotwork,fineline,trash_polka,neotradicional,lettering,outro',
            'avaliacao_atendimento'=> 'required|integer|min:1|max:5',
            'avaliacao_resultado'  => 'required|integer|min:1|max:5',
            'comentario'           => 'nullable|string',
            'destaque'             => 'nullable|boolean',
            'funcionario_id'       => 'required|exists:funcionarios,id',
            'agendamento_id'       => 'nullable|exists:agendamentos,id',
        ], [
            'nome_cliente.required'         => 'O nome do cliente é obrigatório.',
            'imagem_tatuagem.required'      => 'A imagem da tatuagem é obrigatória.',
            'estilo_tatuagem.required'      => 'O estilo da tatuagem é obrigatório.',
            'avaliacao_atendimento.required'=> 'Avalie o atendimento.',
            'avaliacao_resultado.required'  => 'Avalie o resultado.',
            'funcionario_id.required'       => 'Selecione o tatuador.',
        ]);

        if ($request->hasFile('imagem_tatuagem')) {
            $validated['imagem_tatuagem'] = $request->file('imagem_tatuagem')->store('galerias/tatuagens', 'public');
        }

        if ($request->hasFile('foto_perfil_cliente')) {
            $validated['foto_perfil_cliente'] = $request->file('foto_perfil_cliente')->store('galerias/clientes', 'public');
        }

        $validated['destaque'] = $request->has('destaque') ? true : false;

        Galeria::create($validated);

        return redirect()->route('galerias.index')
            ->with('success', 'Trabalho adicionado à galeria com sucesso!');
    }

    public function show(Galeria $galeria)
    {
        $galeria->load('funcionario', 'agendamento');
        return view('galerias.show', compact('galeria'));
    }

    public function edit(Galeria $galeria)
    {
        $tatuadores = Funcionario::tatuadores()->orderBy('nome')->get();
        return view('galerias.edit', compact('galeria', 'tatuadores'));
    }

    public function update(Request $request, Galeria $galeria)
    {
        $validated = $request->validate([
            'nome_cliente'         => 'required|string|max:255',
            'foto_perfil_cliente'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'imagem_tatuagem'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'estilo_tatuagem'      => 'required|in:realismo,blackwork,aquarela,old_school,new_school,geometrico,minimalista,tribal,japones,dotwork,fineline,trash_polka,neotradicional,lettering,outro',
            'avaliacao_atendimento'=> 'required|integer|min:1|max:5',
            'avaliacao_resultado'  => 'required|integer|min:1|max:5',
            'comentario'           => 'nullable|string',
            'destaque'             => 'nullable|boolean',
            'funcionario_id'       => 'required|exists:funcionarios,id',
        ]);

        if ($request->hasFile('imagem_tatuagem')) {
            Storage::disk('public')->delete($galeria->imagem_tatuagem);
            $validated['imagem_tatuagem'] = $request->file('imagem_tatuagem')->store('galerias/tatuagens', 'public');
        }

        if ($request->hasFile('foto_perfil_cliente')) {
            if ($galeria->foto_perfil_cliente) {
                Storage::disk('public')->delete($galeria->foto_perfil_cliente);
            }
            $validated['foto_perfil_cliente'] = $request->file('foto_perfil_cliente')->store('galerias/clientes', 'public');
        }

        $validated['destaque'] = $request->has('destaque') ? true : false;

        $galeria->update($validated);

        return redirect()->route('galerias.show', $galeria)
            ->with('success', 'Entrada da galeria atualizada com sucesso!');
    }

    public function destroy(Galeria $galeria)
    {
        Storage::disk('public')->delete($galeria->imagem_tatuagem);
        if ($galeria->foto_perfil_cliente) {
            Storage::disk('public')->delete($galeria->foto_perfil_cliente);
        }

        $galeria->delete();

        return redirect()->route('galerias.index')
            ->with('success', 'Entrada removida da galeria com sucesso!');
    }

    /**
     * Exibe o perfil público de um tatuador com toda a sua galeria.
     */
    public function perfilTatuador(Funcionario $funcionario)
    {
        if ($funcionario->funcao !== 'tatuador') {
            abort(404);
        }

        $galerias = $funcionario->galerias()
            ->orderByDesc('destaque')
            ->orderBy('created_at', 'desc')
            ->get();

        $estatisticas = [
            'total_trabalhos'    => $galerias->count(),
            'media_atendimento'  => round($galerias->avg('avaliacao_atendimento'), 1),
            'media_resultado'    => round($galerias->avg('avaliacao_resultado'), 1),
            'estilos'            => $galerias->groupBy('estilo_tatuagem')->keys(),
        ];

        // Agendamentos concluídos do tatuador para a seção de histórico
        $agendamentosConcluidos = $funcionario->agendamentos()
            ->where('status', 'concluido')
            ->orderBy('data_agendamento', 'desc')
            ->get();

        return view('galerias.perfil_tatuador', compact('funcionario', 'galerias', 'estatisticas', 'agendamentosConcluidos'));
    }

    /**
     * Adiciona todos os agendamentos concluídos de um tatuador à galeria de uma vez.
     */
    public function importarAgendamentos(Request $request, Funcionario $funcionario)
    {
        if ($funcionario->funcao !== 'tatuador') {
            return back()->with('error', 'Apenas tatuadores podem ter entradas na galeria.');
        }

        $agendamentosIds = $request->input('agendamentos', []);

        if (empty($agendamentosIds)) {
            return back()->with('error', 'Selecione pelo menos um agendamento para importar.');
        }

        $agendamentos = Agendamento::whereIn('id', $agendamentosIds)
            ->where('funcionario_id', $funcionario->id)
            ->where('status', 'concluido')
            ->whereDoesntHave('galeria') // Não importa os que já estão na galeria
            ->get();

        $importados = 0;
        foreach ($agendamentos as $agendamento) {
            if ($agendamento->imagem_tatuagem) {
                Galeria::create([
                    'nome_cliente'          => $agendamento->nome_cliente,
                    'imagem_tatuagem'       => $agendamento->imagem_tatuagem,
                    'foto_perfil_cliente'   => $agendamento->foto_perfil,
                    'estilo_tatuagem'       => 'outro',
                    'avaliacao_atendimento' => 5,
                    'avaliacao_resultado'   => 5,
                    'funcionario_id'        => $funcionario->id,
                    'agendamento_id'        => $agendamento->id,
                ]);
                $importados++;
            }
        }

        return back()->with('success', "{$importados} trabalho(s) importado(s) para a galeria com sucesso!");
    }
}
