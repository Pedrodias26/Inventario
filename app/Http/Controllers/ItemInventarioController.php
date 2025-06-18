<?php

namespace App\Http\Controllers;

use App\Models\{ItemInventario, Inventario, Produto, HistoricoContagem};
use Illuminate\Http\Request;

class ItemInventarioController extends Controller
{
    public function create(Inventario $inventario)
    {
        if ($inventario->empresa_id !== session('empresa_id')) {
            abort(403, 'Acesso negado.');
        }

        return view('itens_inventario.create', compact('inventario'));
    }

    public function store(Request $request, Inventario $inventario)
    {
        if ($inventario->empresa_id !== session('empresa_id')) {
            abort(403, 'Acesso negado.');
        }

        $empresaId = session('empresa_id');
        $posicaoVazia = $request->has('posicao_vazia');

        $rules = [
            'validade' => $posicaoVazia ? 'nullable|date' : 'required|date',
            'lote' => 'nullable|string|max:255',
        ];

        if (!$posicaoVazia) {
            $rules = array_merge($rules, [
                'EAN' => 'required|string',
                'quantidade_contada' => 'required|integer|min:0',
                'quantidade_esperada' => 'nullable|integer',
            ]);
        }

        $request->validate($rules);

        ItemInventario::where('inventario_id', $inventario->id)
            ->where('local_contagem', $inventario->local)
            ->delete();

        if ($posicaoVazia) {
            $produto = Produto::where('empresa_id', $empresaId)
                ->where('local_armazenamento', $inventario->local)
                ->first();

            if ($produto) {
                $quantidadeEsperada = $produto->quantidade;

                $item = ItemInventario::create([
                    'inventario_id' => $inventario->id,
                    'produto_id' => $produto->id,
                    'quantidade_contada' => 0,
                    'diferenca' => -$quantidadeEsperada,
                    'local_contagem' => $inventario->local,
                    'validade' => $request->validade,
                    'status' => 'contado',
                    'valor_unitario' => $produto->valor_unitario,
                    'justificativa' => 'Produto removido da posição',
                    'lote' => null,
                    'empresa_id' => $empresaId,
                ]);

                HistoricoContagem::create([
                    'item_inventario_id' => $item->id,
                    'quantidade_contada' => 0,
                    'quantidade_esperada' => $quantidadeEsperada,
                    'diferenca' => -$quantidadeEsperada,
                    'lote' => null,
                    'validade' => $request->validade,
                    'justificativa' => 'Produto removido da posição',
                    'empresa_id' => $empresaId,
                    'registrado_em' => now(),
                ]);
            } else {
                $item = ItemInventario::create([
                    'inventario_id' => $inventario->id,
                    'produto_id' => null,
                    'quantidade_contada' => 0,
                    'diferenca' => 0,
                    'local_contagem' => $inventario->local,
                    'validade' => $request->validade,
                    'status' => 'contado',
                    'valor_unitario' => 0,
                    'justificativa' => 'Posição vazia sem produto',
                    'lote' => null,
                    'empresa_id' => $empresaId,
                ]);
            }
        } else {
            $produto = Produto::where('empresa_id', $empresaId)
                ->where('EAN', $request->EAN)
                ->first();

            if (!$produto) {
                return back()->withInput()->with('error', 'Produto com EAN informado não foi encontrado.');
            }

            $quantidadeEsperada = $produto->quantidade;
            $quantidadeContada = (int) $request->quantidade_contada;
            $diferenca = $quantidadeContada - $quantidadeEsperada;

            $item = ItemInventario::create([
                'inventario_id' => $inventario->id,
                'produto_id' => $produto->id,
                'quantidade_contada' => $quantidadeContada,
                'diferenca' => $diferenca,
                'local_contagem' => $inventario->local,
                'validade' => $request->validade,
                'status' => 'contado',
                'valor_unitario' => $produto->valor_unitario,
                'justificativa' => null,
                'lote' => $request->lote,
                'empresa_id' => $empresaId,
            ]);

            HistoricoContagem::create([
                'item_inventario_id' => $item->id,
                'quantidade_contada' => $quantidadeContada,
                'quantidade_esperada' => $quantidadeEsperada,
                'diferenca' => $diferenca,
                'lote' => $request->lote,
                'validade' => $request->validade,
                'justificativa' => null,
                'empresa_id' => $empresaId,
                'registrado_em' => now(),
            ]);
        }

        return $this->finalizarContagem($inventario, 'Contagem registrada com sucesso.');
    }

    private function finalizarContagem(Inventario $inventario, string $mensagem)
    {
        return auth()->user()->role === 'auditor'
            ? redirect()->route('auditor.inventario')->with('success', $mensagem)
            : redirect()->route('inventario.show', $inventario->id)->with('success', $mensagem);
    }

    public function proximoInventario()
    {
        $usuario = auth()->user();

        if ($usuario->role !== 'auditor') {
            return redirect()->route('home');
        }

        $empresaId = session('empresa_id');

        $inventario = Inventario::where('empresa_id', $empresaId)
            ->where('status', 'em_contagem')
            ->orderBy('id')
            ->first();

        return $inventario
            ? redirect()->route('itens-inventario.create', $inventario->id)
            : view('itens_inventario.nenhum');
    }

    public function lancarInventario($id)
    {
        $empresaId = session('empresa_id');

        $inventario = Inventario::with('itens')->where('empresa_id', $empresaId)->findOrFail($id);

        foreach ($inventario->itens as $item) {
            if ($item->produto_id && $item->status === 'contado') {
                $produto = Produto::where('empresa_id', $empresaId)->find($item->produto_id);
                if ($produto) {
                    $produto->quantidade = $item->quantidade_contada;
                    $produto->validade = $item->validade;
                    $produto->local_armazenamento = $item->local_contagem;
                    $produto->save();

                    $item->status = 'lancado';
                    $item->save();
                }
            }
        }

        $inventario->status = 'finalizado';
        $inventario->save();

        return back()->with('success', 'Inventário lançado com sucesso e estoque atualizado.');
    }

    public function cancelar($id)
    {
        $empresaId = session('empresa_id');

        $item = ItemInventario::where('empresa_id', $empresaId)->findOrFail($id);
        $item->status = 'cancelado';
        $item->save();

        return back()->with('success', 'Item cancelado com sucesso.');
    }
}
