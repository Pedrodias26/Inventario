<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemInventario extends Model
{
    protected $table = 'itens_inventario';

    protected $fillable = [
        'inventario_id',
        'produto_id',
        'quantidade_contada',
        'diferenca',
        'local_contagem',
        'validade',
        'status',
        'valor_unitario'
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function inventario()
    {
        return $this->belongsTo(Inventario::class);
    }
}