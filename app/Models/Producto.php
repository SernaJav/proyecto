<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    use HasFactory;

    // =========================
    // tabla real
    // =========================
    protected $table = 'productos';

    // =========================
    // campos permitidos
    // =========================
    protected $fillable = [

        // =========================
        // nombre producto
        // =========================
        'nombre',

        // =========================
        // precio compra
        // =========================
        'preciocompra',

        // =========================
        // descripción
        // =========================
        'descripcion',

        // =========================
        // stock máximo
        // =========================
        'stockmaximo',

        // =========================
        // stock actual
        // =========================
        'stock',

        // =========================
        // imagen
        // =========================
        'imagen',

        // =========================
        // estado
        // =========================
        'estado',

        // =========================
        // usuario
        // =========================
        'registradopor'
    ];

    // =========================
    // relación detalles compras
    // =========================
    public function detallesCompras(): HasMany
    {
        return $this->hasMany(
            DetalleCompra::class,
            'producto_id'
        );
    }
}