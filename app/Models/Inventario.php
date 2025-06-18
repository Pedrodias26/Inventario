<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'local',
        'status',
        'empresa_id', // incluído para multiempresa
    ];

    /**
     * Relacionamento com os itens de inventário.
     */
    public function itens()
    {
        return $this->hasMany(ItemInventario::class);
    }

    /**
     * Relacionamento com a empresa.
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
