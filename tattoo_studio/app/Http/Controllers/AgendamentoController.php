<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AgendamentoController extends Controller
{
    public function index(Request $request)
    {
        $query = Agendamento::with('funcionario');

        if ($request->filled('busca')) {
            $query->where('nome_cliente', 'like', '%' . $request->busca . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tatuador')) {
            $query->where('funcionario_id', $request->tatuador);
        }

        if ($request->filled('data')) {
            $query->whereDate('data_agendamento', $request->data);
        }

        $agendamentos = $query->orderBy('data_agendamento', 'desc')
            ->orderBy('hora_agendamento')
            ->paginate(10)
            ->withQueryString();

        $tatuadores = Funcionario::tatuadores()->orderBy('nome')->get();

        return view('agendamentos.index', compact('agendamentos', 'tatuadores'));
    }

    public function create()
    {
        // Apenas tatuadores ativos podem ser selecionados
        $tatuadores = Funcionario::tatuadores()->orderBy('nome')->get();

        if ($tatuadores->isEmpty()) {
            return redirect()->route('agendamentos.index')
                ->with('error', 'Nenhum tatuador cadastrado. Cadastre um tatuador antes de criar agendamentos.');
        }

        return view('agendamentos.create', compact('tatuadores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome_cliente'       => 'required|string|max:255',
            'idade_cliente'      => 'required|integer|min:18|max:100',
            'telefone'           => 'nullable|string|max:20',
            'email'              => 'nullable|email|max:255',
            'foto_perfil'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'imagem_tatuagem'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'descricao_tatuagem' => 'nullable|string',
            'local_corpo'        => 'nullable|string|max:100',
            'tamanho'            => 'nullable|string|max:50',
            'data_agendamento'   => 'required|date|after_or_equal:today',
            'hora_agendamento'   => 'required',
            'valor_estimado'     => 'nullable|numeric|min:0',
            'forma_pagamento'    => 'required|in:dinheiro,cartao_credito,cartao_debito,pix,transferencia',
            'parcelas'           => 'nullable|integer|min:1|max:24',
            'observacoes'        => 'nullable|string',
            'funcionario_id'     => [
                'required',
                'exists:funcionarios,id',
                function ($attribute, $value, $fail) {
                    $funcionario = Funcionario::find($value);
                    if (!$funcionario || $funcionario->funcao !== 'tatuador' || !$funcionario->ativo) {
                        $fail('O profissional selecionado deve ser um tatuador ativo.');
                    }
                },
            ],
        ], [
            'nome_cliente.required'      => 'O nome do cliente é obrigatório.',
            'idade_cliente.required'     => 'A idade do cliente é obrigatória.',
            'idade_cliente.min'          => 'O cliente deve ter pelo menos 18 anos.',
            'data_agendamento.required'  => 'A data é obrigatória.',
            'data_agendamento.after_or_equal' => 'A data deve ser hoje ou uma data futura.',
            'hora_agendamento.required'  => 'O horário é obrigatório.',
            'forma_pagamento.required'   => 'A forma de pagamento é obrigatória.',
            'funcionario_id.required'    => 'Selecione um tatuador.',
        ]);

        if ($request->hasFile('foto_perfil')) {
            $validated['foto_perfil'] = $request->file('foto_perfil')->store('agendamentos/fotos', 'public');
        }

        if ($request->hasFile('imagem_tatuagem')) {
            $validated['imagem_tatuagem'] = $request->file('imagem_tatuagem')->store('agendamentos/tatuagens', 'public');
        }

        $validated['parcelas'] = $validated['parcelas'] ?? 1;

        Agendamento::create($validated);

        return redirect()->route('agendamentos.index')
            ->with('success', 'Agendamento criado com sucesso!');
    }

    public function show(Agendamento $agendamento)
    {
        $agendamento->load('funcionario', 'galeria');
        return view('agendamentos.show', compact('agendamento'));
    }

    public function edit(Agendamento $agendamento)
    {
        $tatuadores = Funcionario::tatuadores()->orderBy('nome')->get();
        return view('agendamentos.edit', compact('agendamento', 'tatuadores'));
    }

    public function update(Request $request, Agendamento $agendamento)
    {
        $validated = $request->validate([
            'nome_cliente'       => 'required|string|max:255',
            'idade_cliente'      => 'required|integer|min:18|max:100',
            'telefone'           => 'nullable|string|max:20',
            'email'              => 'nullable|email|max:255',
            'foto_perfil'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'imagem_tatuagem'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'descricao_tatuagem' => 'nullable|string',
            'local_corpo'        => 'nullable|string|max:100',
            'tamanho'            => 'nullable|string|max:50',
            'data_agendamento'   => 'required|date',
            'hora_agendamento'   => 'required',
            'valor_estimado'     => 'nullable|numeric|min:0',
            'forma_pagamento'    => 'required|in:dinheiro,cartao_credito,cartao_debito,pix,transferencia',
            'parcelas'           => 'nullable|integer|min:1|max:24',
            'status'             => 'required|in:pendente,confirmado,concluido,cancelado',
            'observacoes'        => 'nullable|string',
            'funcionario_id'     => [
                'required',
                'exists:funcionarios,id',
                function ($attribute, $value, $fail) {
                    $funcionario = Funcionario::find($value);
                    if (!$funcionario || $funcionario->funcao !== 'tatuador') {
                        $fail('O profissional selecionado deve ser um tatuador.');
                    }
                },
            ],
        ]);

        if ($request->hasFile('foto_perfil')) {
            if ($agendamento->foto_perfil) {
                Storage::disk('public')->delete($agendamento->foto_perfil);
            }
            $validated['foto_perfil'] = $request->file('foto_perfil')->store('agendamentos/fotos', 'public');
        }

        if ($request->hasFile('imagem_tatuagem')) {
            if ($agendamento->imagem_tatuagem) {
                Storage::disk('public')->delete($agendamento->imagem_tatuagem);
            }
            $validated['imagem_tatuagem'] = $request->file('imagem_tatuagem')->store('agendamentos/tatuagens', 'public');
        }

        $agendamento->update($validated);

        return redirect()->route('agendamentos.show', $agendamento)
            ->with('success', 'Agendamento atualizado com sucesso!');
    }

    public function destroy(Agendamento $agendamento)
    {
        if ($agendamento->foto_perfil) {
            Storage::disk('public')->delete($agendamento->foto_perfil);
        }
        if ($agendamento->imagem_tatuagem) {
            Storage::disk('public')->delete($agendamento->imagem_tatuagem);
        }

        $agendamento->delete();

        return redirect()->route('agendamentos.index')
            ->with('success', 'Agendamento excluído com sucesso!');
    }

    /**
     * Atualiza apenas o status do agendamento.
     */
    public function updateStatus(Request $request, Agendamento $agendamento)
    {
        $validated = $request->validate([
            'status' => 'required|in:pendente,confirmado,concluido,cancelado',
        ]);

        $agendamento->update($validated);

        return back()->with('success', 'Status atualizado para "' . ucfirst($validated['status']) . '".');
    }
}
