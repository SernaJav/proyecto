<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\MetodoPago;
use App\Models\OrdenCompra;
use App\Models\DetalleCompra;
use App\Models\Pago;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('12345678')
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | PROVEEDORES
        |--------------------------------------------------------------------------
        */

        Proveedor::factory(30)->create();

        /*
        |--------------------------------------------------------------------------
        | PRODUCTOS REALES
        |--------------------------------------------------------------------------
        */

        $productos = [
            ['nombre' => 'Jabón', 'precio' => 4500, 'imagen' => 'images/productos/jabon.png'],
            ['nombre' => 'Aceite', 'precio' => 8000, 'imagen' => 'images/productos/aceite.png'],
            ['nombre' => 'Harina', 'precio' => 3200, 'imagen' => 'images/productos/harina.png'],
            ['nombre' => 'Arroz', 'precio' => 2500, 'imagen' => 'images/productos/arroz.png'],
            ['nombre' => 'Azúcar', 'precio' => 2800, 'imagen' => 'images/productos/azucar.png'],
            ['nombre' => 'Leche', 'precio' => 4600, 'imagen' => 'images/productos/leche.png'],
            ['nombre' => 'Café', 'precio' => 16000, 'imagen' => 'images/productos/cafe.png'],
            ['nombre' => 'Sal', 'precio' => 5500, 'imagen' => 'images/productos/sal.png'],
            ['nombre' => 'Pasta', 'precio' => 2200, 'imagen' => 'images/productos/pasta.png'],
            ['nombre' => 'Galletas', 'precio' => 8200, 'imagen' => 'images/productos/galletas.png'],
        ];

        foreach ($productos as $producto) {
            Producto::create([
                'nombre' => $producto['nombre'],
                'preciocompra' => $producto['precio'],
                'descripcion' => 'Producto registrado por seeder',
                'stockmaximo' => rand(100, 300),
                'stock' => rand(50, 150),
                'imagen' => $producto['imagen'],
                'estado' => 1,
                'registradopor' => 'Seeder',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | METODOS DE PAGO
        |--------------------------------------------------------------------------
        */

        $metodosPago = [
            ['nombre' => 'Efectivo', 'descripcion' => 'Pago en efectivo'],
            ['nombre' => 'Transferencia', 'descripcion' => 'Transferencia bancaria'],
            ['nombre' => 'Tarjeta Débito', 'descripcion' => 'Tarjeta débito'],
            ['nombre' => 'Tarjeta Crédito', 'descripcion' => 'Tarjeta crédito'],
        ];

        foreach ($metodosPago as $metodo) {
            MetodoPago::create([
                'nombre' => $metodo['nombre'],
                'descripcion' => $metodo['descripcion'],
                'estado' => 1,
                'registradopor' => 'Seeder',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ORDENES
        |--------------------------------------------------------------------------
        */

        $ordenes = OrdenCompra::factory(20)->create();

        /*
        |--------------------------------------------------------------------------
        | DETALLES
        |--------------------------------------------------------------------------
        */

        DetalleCompra::factory(40)->create();

        /*
        |--------------------------------------------------------------------------
        | PAGOS
        |--------------------------------------------------------------------------
        */

        $metodoPagoIds = MetodoPago::pluck('id')->toArray();

        foreach ($ordenes as $orden) {
            Pago::create([
                'ordencompra_id' => $orden->id,
                'fechapago' => now()->subDays(rand(0, 90)),
                'monto' => $this->calculatePaymentAmount($orden->total),
                'metodopago_id' => $this->fakerConsultMethod($metodoPagoIds),
                'registradopor' => 'Seeder',
            ]);
        }
    }

    private function calculatePaymentAmount(float $total): float
    {
        $monto = $total * (0.45 + rand(0, 50) / 100);
        return round(min($total, max(10, $monto)), 2);
    }

    private function fakerConsultMethod(array $metodoPagoIds): int
    {
        return $metodoPagoIds[array_rand($metodoPagoIds)];
    }
}
