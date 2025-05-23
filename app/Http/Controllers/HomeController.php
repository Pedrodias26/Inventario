<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\ItemInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');

        $query = ItemInventario::query();

        if ($dataInicio && $dataFim) {
            $query->whereBetween('created_at', [$dataInicio, $dataFim]);
        }

        $quantidadePorDia = $query->clone()
            ->select(DB::raw('DATE(created_at) as data'), DB::raw('SUM(diferenca) as total'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('data')
            ->get();

        $valorPorDia = $query->clone()
            ->select(DB::raw('DATE(created_at) as data'), DB::raw('SUM(diferenca * valor_unitario) as total'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('data')
            ->get();

        $labels = $quantidadePorDia->pluck('data')->toArray();
        $quantidades = $quantidadePorDia->pluck('total')->toArray();
        $valores = $valorPorDia->pluck('total')->toArray();

        return view('home', [
            'inventariosCriados' => Inventario::count(),
            'emContagem' => Inventario::where('status', 'em_contagem')->count(),
            'finalizados' => Inventario::where('status', 'finalizado')->count(),
            'labels' => $labels,
            'quantidades' => $quantidades,
            'valores' => $valores,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim
        ]);
    }
}