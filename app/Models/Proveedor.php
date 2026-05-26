<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores'; // ⚠️ IMPORTANTE revisar nombre real

    protected $fillable = [
        'nombre',
        'documento',
        'direccion',
        'telefono',
        'email',
        'estado',
        'registradopor'
    ];

    public function ordenesCompra(): HasMany
    {
        return $this->hasMany(OrdenCompra::class, 'proveedor_id');
    }
}