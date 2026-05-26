<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrdenCompra extends Model
{
    use HasFactory;

    // =========================
    // TABLA
    // =========================
    protected $table = 'ordencompras';

    // =========================
    // CAMPOS QUE SE PUEDEN GUARDAR
    // =========================
    protected $fillable = [
        'fecha',
        'proveedor_id',   // 👈 CORREGIDO (antes estaba mal escrito)
        'total',
        'tipopago',
        'saldopendiente',
        'estado',
        'registradopor'
    ];

    // =========================
    // CASTS
    // =========================
    protected $casts = [
        'fecha' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // =========================
    // RELACIÓN: UNA ORDEN TIENE UN PROVEEDOR
    // =========================
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(
            Proveedor::class,
            'proveedor_id'
        );
    }

    // =========================
    // RELACIÓN: UNA ORDEN TIENE MUCHOS DETALLES
    // =========================
    public function detallesCompras(): HasMany
    {
        return $this->hasMany(
            DetalleCompra::class,
            'ordencompra_id'
        );
    }

    // =========================
    // RELACIÓN: UNA ORDEN TIENE MUCHOS PAGOS
    // =========================
    public function pagos(): HasMany
    {
        return $this->hasMany(
            Pago::class,
            'ordencompra_id'
        );
    }
}