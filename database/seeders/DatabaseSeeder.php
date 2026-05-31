<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Metodopago;
use App\Models\Ordencompra;
use App\Models\DetalleCompra;
use App\Models\Pago;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // USUARIOS
        // =========================
        User::factory(5)->create();

        // =========================
        // PROVEEDORES (más realista)
        // =========================
        Proveedor::factory(15)->create();

        // =========================
        // PRODUCTOS
        // =========================
        Producto::factory(25)->create();

        // =========================
        // MÉTODOS DE PAGO (POCOS, REALISTA)
        // =========================
        Metodopago::create([
            'nombre' => 'Efectivo',
            'descripcion' => 'Pago en efectivo',
            'estado' => 1,
            'registradopor' => 'Seeder'
        ]);

        Metodopago::create([
            'nombre' => 'Transferencia',
            'descripcion' => 'Transferencia bancaria',
            'estado' => 1,
            'registradopor' => 'Seeder'
        ]);

        Metodopago::create([
            'nombre' => 'Tarjeta',
            'descripcion' => 'Débito o crédito',
            'estado' => 1,
            'registradopor' => 'Seeder'
        ]);

        Metodopago::create([
            'nombre' => 'Contraentrega',
            'descripcion' => 'Pago al recibir',
            'estado' => 1,
            'registradopor' => 'Seeder'
        ]);

        // =========================
        // ÓRDENES (dependen de proveedor)
        // =========================
        Ordencompra::factory(20)->create();

        // =========================
        // DETALLES
        // =========================
        DetalleCompra::factory(40)->create();

        // =========================
        // PAGOS
        // =========================
        Pago::factory(20)->create();
    }
}