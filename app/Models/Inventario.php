<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $fillable = ['local', 'status'];

    public function itens()
    {
        return $this->hasMany(ItemInventario::class);
    }
}