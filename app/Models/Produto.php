<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_interno',
        'nome',
        'descricao',
        'quantidade',
        'local_armazenamento',
        'lote',
        'validade',
        'status',
        'EAN',
        'valor_unitario',
    ];
}
