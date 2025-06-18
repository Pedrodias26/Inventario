<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemInventario extends Model
{
    use HasFactory;

    protected $table = 'itens_inventario';

    protected $fillable = [
        'inventario_id',
        'produto_id',
        'EAN',
        'quantidade_contada',
        'diferenca',
        'local_contagem',
        'validade',
        'status',
        'valor_unitario',
        'justificativa',
        'lote',
        'empresa_id', // adicionado para multiempresa
    ];

    /**
     * Relacionamento com o produto.
     */
    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    /**
     * Relacionamento com o inventário.
     */
    public function inventario()
    {
        return $this->belongsTo(Inventario::class);
    }

    /**
     * Relacionamento com a empresa.
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
