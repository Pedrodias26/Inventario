<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoricoContagem;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioController extends Controller
{
    public function index(Request $request)
    {
        $empresaId = session('empresa_id');

        $query = HistoricoContagem::with('produto')
            ->where('empresa_id', $empresaId);

        if ($request->filled('produto')) {
            $query->whereHas('produto', function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->produto . '%');
            });
        }

        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $query->whereBetween('registrado_em', [$request->data_inicio, $request->data_fim]);
        }

        $historicos = $query->orderBy('registrado_em', 'desc')->paginate(20);

        return view('relatorio.index', compact('historicos'));
    }

    public function exportarPdf(Request $request)
    {
        $empresaId = session('empresa_id');

        $query = HistoricoContagem::with('produto')
            ->where('empresa_id', $empresaId);

        if ($request->filled('produto')) {
            $query->whereHas('produto', function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->produto . '%');
            });
        }

        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $query->whereBetween('registrado_em', [$request->data_inicio, $request->data_fim]);
        }

        $historicos = $query->orderBy('registrado_em', 'desc')->get();

        $pdf = Pdf::loadView('relatorio.pdf', compact('historicos'));
        return $pdf->download('relatorio-inventario.pdf');
    }
}
