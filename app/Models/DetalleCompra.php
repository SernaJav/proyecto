<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetalleCompra extends Model
{
    use HasFactory;
    // =========================
    // aquí se dice la tabla real
    // =========================
    protected $table = 'detallescompras';

    // =========================
    // lo que se puede guardar
    // =========================
    protected $fillable = [
        'ordencompra_id',
        'producto_id',
        'cantidad',
        'subtotal',
        'registradopor'
    ];

    // =========================
    // conexión con orden de compra
    // =========================
    public function ordenCompra()
{
    return $this->belongsTo(
        OrdenCompra::class,
        'ordencompra_id'
    );
}

    // =========================
    // conexión con producto
    // =========================
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}