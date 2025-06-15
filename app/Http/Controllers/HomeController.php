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
        // Recebe as datas do formulário (filtro)
        $dataInicio = $request->input('start_date');
        $dataFim = $request->input('end_date');

        // Inicia a query base
        $query = ItemInventario::query();

        // Aplica o filtro por data se ambos os campos estiverem preenchidos
        if ($dataInicio && $dataFim) {
            $query->whereBetween('created_at', [
                $dataInicio . ' 00:00:00',
                $dataFim . ' 23:59:59'
            ]);
        }

        // Gráfico: Diferença de Quantidade por dia
        $quantidadePorDia = (clone $query)
            ->select(DB::raw('DATE(created_at) as data'), DB::raw('SUM(diferenca) as total'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('data')
            ->get();

        // Gráfico: Diferença de Valor por dia
        $valorPorDia = (clone $query)
            ->select(DB::raw('DATE(created_at) as data'), DB::raw('SUM(diferenca * valor_unitario) as total'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('data')
            ->get();

        // Extrai os dados para os gráficos
        $labels = $quantidadePorDia->pluck('data')->toArray();
        $quantidades = $quantidadePorDia->pluck('total')->toArray();
        $valores = $valorPorDia->pluck('total')->toArray();

        // Retorna a view com os dados necessários
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
