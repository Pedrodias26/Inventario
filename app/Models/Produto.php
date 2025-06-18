<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'nome',
        'EAN',
        'descricao',
        'quantidade',
        'local_armazenamento',
        'lote',
        'validade',
        'status',
        'valor_unitario',
        'codigo_interno',
    ];

    public function itensInventario()
    {
        return $this->hasMany(\App\Models\ItemInventario::class, 'produto_id');
    }
}
