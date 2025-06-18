<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'razao_social',
        'cnpj',
        'endereco',
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }

    public function inventarios()
    {
        return $this->hasMany(Inventario::class);
    }

    public function itensInventario()
    {
        return $this->hasMany(ItemInventario::class);
    }
}
