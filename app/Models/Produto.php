<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

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
        'empresa_id', // incluído para multiempresa
    ];

    /**
     * Relacionamento com os itens de inventário.
     */
    public function itensInventario()
    {
        return $this->hasMany(\App\Models\ItemInventario::class, 'produto_id');
    }

    /**
     * Relacionamento com a empresa.
     */
    public function empresa()
    {
        return $this->belongsTo(\App\Models\Empresa::class);
    }
}
