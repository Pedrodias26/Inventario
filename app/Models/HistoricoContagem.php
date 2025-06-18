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
            Produto::class,             // Tabela de destino
            ItemInventario::class,      // Tabela intermediária
            'id',                       // Chave primária do intermediário (ItemInventario)
            'id',                       // Chave primária da tabela de destino (Produto)
            'item_inventario_id',       // Chave estrangeira local
            'produto_id'                // Chave estrangeira no intermediário
        );
    }
}