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
        $dataInicio = $request->input('start_date') ?? now()->subDays(7)->format('Y-m-d');
        $dataFim = $request->input('end_date') ?? now()->format('Y-m-d');

        $query = ItemInventario::whereBetween('created_at', [
            $dataInicio . ' 00:00:00',
            $dataFim . ' 23:59:59'
        ]);

        $quantidadePorDia = (clone $query)
            ->select(DB::raw('DATE(created_at) as data'), DB::raw('SUM(diferenca) as total'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('data')
            ->get();

        $valorPorDia = (clone $query)
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
            'dataFim' => $dataFim,
            'temDados' => count($labels) > 0
        ]);
    }
}
