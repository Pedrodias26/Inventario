<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class HistoricoContagem extends Model
{
    public $timestamps = false;

    protected $table = 'historico_contagem';

    protected $fillable = [
        'item_inventario_id',
        'quantidade_contada',
        'quantidade_esperada',
        'diferenca',
        'lote',
        'validade',
        'justificativa',
        'registrado_em',
        'empresa_id', // incluído para multiempresa
    ];

    /**
     * Relacionamento com o item de inventário.
     */
    public function itemInventario(): BelongsTo
    {
        return $this->belongsTo(ItemInventario::class);
    }

    /**
     * Acesso ao produto diretamente através do item de inventário.
     */
    public function produto(): HasOneThrough
    {
        return $this->hasOneThrough(
            Produto::class,             // Model de destino
            ItemInventario::class,      // Model intermediário
            'id',                       // PK em ItemInventario
            'id',                       // PK em Produto
            'item_inventario_id',       // FK neste model
            'produto_id'                // FK em ItemInventario
        );
    }

    /**
     * Relacionamento com a empresa.
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }
}
