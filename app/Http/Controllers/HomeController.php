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

        // Conversão para datetime com hora
        $inicio = $dataInicio . ' 00:00:00';
        $fim = $dataFim . ' 23:59:59';

        // Filtro nos Itens de Inventário para os gráficos
        $query = ItemInventario::whereBetween('created_at', [$inicio, $fim]);

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

        // Filtro nos Inventários apenas dentro do período
        $inventariosFiltrados = Inventario::whereBetween('created_at', [$inicio, $fim]);

        $inventariosCriados = (clone $inventariosFiltrados)->count();
        $emContagem = (clone $inventariosFiltrados)->where('status', 'em_contagem')->count();
        $finalizados = (clone $inventariosFiltrados)->where('status', 'finalizado')->count();

        $labels = $quantidadePorDia->pluck('data')->toArray();
        $quantidades = $quantidadePorDia->pluck('total')->toArray();
        $valores = $valorPorDia->pluck('total')->toArray();

        return view('home', [
            'inventariosCriados' => $inventariosCriados,
            'emContagem' => $emContagem,
            'finalizados' => $finalizados,
            'labels' => $labels,
            'quantidades' => $quantidades,
            'valores' => $valores,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'temDados' => count($labels) > 0
        ]);
    }
}