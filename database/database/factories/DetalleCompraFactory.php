<?php

namespace Database\Factories;

use App\Models\DetalleCompra;
use App\Models\OrdenCompra;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetalleCompra>
 */
class DetalleCompraFactory extends Factory
{
    protected $model = DetalleCompra::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = $this->faker ?? fake();
        $cantidad = $faker->numberBetween(1, 5);
        $precio = $faker->randomFloat(2, 100, 500);

        return [
            'ordencompra_id' => $faker->randomElement(OrdenCompra::pluck('id')->toArray()),
            'producto_id' => $faker->randomElement(Producto::pluck('id')->toArray()),
            'cantidad' => $cantidad,
            'subtotal' => $cantidad * $precio,
            'registradopor' => 'Seeder',
        ];
    }
}
