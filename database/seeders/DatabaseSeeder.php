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

            [
                'nombre' => 'Arroz Diana',
                'precio' => 3500,
                'imagen' => 'arroz.png'
            ],

            [
                'nombre' => 'Azucar Manuelita',
                'precio' => 4200,
                'imagen' => 'azucar.png'
            ],

            [
                'nombre' => 'Aceite Premier',
                'precio' => 12500,
                'imagen' => 'aceite.png'
            ],

            [
                'nombre' => 'Cafe Aguila Roja',
                'precio' => 9800,
                'imagen' => 'cafe.png'
            ],

            [
                'nombre' => 'Harina Haz de Oros',
                'precio' => 4300,
                'imagen' => 'harina.png'
            ],

            [
                'nombre' => 'Leche Alqueria',
                'precio' => 4200,
                'imagen' => 'leche.png'
            ],

            [
                'nombre' => 'Pan Integral',
                'precio' => 2800,
                'imagen' => 'pan.png'
            ],

            [
                'nombre' => 'Pasta Doria',
                'precio' => 3500,
                'imagen' => 'pasta.png'
            ],

            [
                'nombre' => 'Sal Refisal',
                'precio' => 2200,
                'imagen' => 'sal.png'
            ],

            [
                'nombre' => 'Galletas Festival',
                'precio' => 3200,
                'imagen' => 'galletas.png'
            ],

            [
                'nombre' => 'Chocolate Corona',
                'precio' => 4800,
                'imagen' => 'galletas.png'
            ],

            [
                'nombre' => 'Atun Van Camps',
                'precio' => 7500,
                'imagen' => 'aceite.png'
            ],

            [
                'nombre' => 'Lentejas',
                'precio' => 2800,
                'imagen' => 'arroz.png'
            ],

            [
                'nombre' => 'Frijoles',
                'precio' => 3500,
                'imagen' => 'arroz.png'
            ],

            [
                'nombre' => 'Avena Quaker',
                'precio' => 6500,
                'imagen' => 'harina.png'
            ]

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
                'registradopor' => 'Seeder'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | METODOS DE PAGO
        |--------------------------------------------------------------------------
        */

        MetodoPago::create([
            'nombre' => 'Efectivo',
            'descripcion' => 'Pago en efectivo',
            'estado' => 1,
            'registradopor' => 'Seeder'
        ]);

        MetodoPago::create([
            'nombre' => 'Transferencia',
            'descripcion' => 'Transferencia bancaria',
            'estado' => 1,
            'registradopor' => 'Seeder'
        ]);

        MetodoPago::create([
            'nombre' => 'Tarjeta Debito',
            'descripcion' => 'Tarjeta débito',
            'estado' => 1,
            'registradopor' => 'Seeder'
        ]);

        MetodoPago::create([
            'nombre' => 'Tarjeta Credito',
            'descripcion' => 'Tarjeta crédito',
            'estado' => 1,
            'registradopor' => 'Seeder'
        ]);

        /*
        |--------------------------------------------------------------------------
        | ORDENES
        |--------------------------------------------------------------------------
        */

        OrdenCompra::factory(50)->create();

        /*
        |--------------------------------------------------------------------------
        | DETALLES
        |--------------------------------------------------------------------------
        */

        DetalleCompra::factory(100)->create();

        /*
        |--------------------------------------------------------------------------
        | PAGOS
        |--------------------------------------------------------------------------
        */

        Pago::factory(50)->create();
    }
}