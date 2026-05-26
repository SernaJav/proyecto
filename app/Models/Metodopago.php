<?php

namespace App\Models;

// =========================
// IMPORTACIONES
// =========================
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MetodoPago extends Model
{
    use HasFactory;

    // =========================
    // TABLA REAL
    // =========================
    protected $table = 'metodopagos';

    // =========================
    // CAMPOS EDITABLES
    // =========================
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
        'registradopor'
    ];

    // =========================
    // RELACIÓN PAGOS
    // =========================
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'metodopago_id');
    }
}