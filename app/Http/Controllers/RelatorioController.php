<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemInventario;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioController extends Controller
{
    public function index(Request $request)
    {
        $query = ItemInventario::with(['inventario', 'produto']);

        if ($request->filled('produto')) {
            $query->whereHas('produto', function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->produto . '%');
            });
        }

        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $query->whereBetween('created_at', [$request->data_inicio, $request->data_fim]);
        }

        $itens = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('relatorio.index', compact('itens'));
    }

    public function exportarPdf(Request $request)
    {
        $query = ItemInventario::with(['inventario', 'produto']);

        if ($request->filled('produto')) {
            $query->whereHas('produto', function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->produto . '%');
            });
        }

        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $query->whereBetween('created_at', [$request->data_inicio, $request->data_fim]);
        }

        $itens = $query->get();

        $pdf = Pdf::loadView('relatorio.pdf', compact('itens'));
        return $pdf->download('relatorio-inventario.pdf');
    }
}
