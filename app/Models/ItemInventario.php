<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemInventario extends Model
{
    protected $fillable = [
        'inventario_id',
        'produto_id',
        'quantidade_registrada',
        'quantidade_contada',
    ];

    public function inventario()
    {
        return $this->belongsTo(ItemInventario::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}