<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = $this->faker ?? fake();
        $stockmaximo = $faker->numberBetween(10, 100);

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

        $producto = $faker->randomElement($productos);

        return [
            'nombre' => $producto['nombre'],
            'preciocompra' => $producto['precio'],
            'descripcion' => $faker->sentence(),
            'stockmaximo' => $stockmaximo,
            'stock' => $faker->numberBetween(0, $stockmaximo),
            'imagen' => $producto['imagen'],
            'estado' => '1',
            'registradopor' => 'Seeder',
        ];
    }
}
