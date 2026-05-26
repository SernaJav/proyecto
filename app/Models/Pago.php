<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    protected $fillable = [
        'ordencompra_id',
        'fechapago',
        'monto',
        'metodopago_id',
        'estado',
        'registradopor'
    ];

    // =========================
    // CASTS
    // =========================
    protected $casts = [
        'fechapago' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function ordenCompra(): BelongsTo
    {
        return $this->belongsTo(OrdenCompra::class, 'ordencompra_id');
    }

    public function metodoPago(): BelongsTo
    {
        return $this->belongsTo(MetodoPago::class, 'metodopago_id');
    }
}