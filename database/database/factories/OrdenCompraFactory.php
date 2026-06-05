<?php

namespace Database\Factories;

use App\Models\OrdenCompra;
use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrdenCompra>
 */
class OrdenCompraFactory extends Factory
{
    protected $model = OrdenCompra::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = $this->faker ?? fake();

        return [
            'fecha' => $faker->dateTimeBetween('-90 days', 'now')->format('Y-m-d'),
            'proveedor_id' => $faker->randomElement(Proveedor::pluck('id')->toArray()),
            'total' => $faker->randomFloat(2, 100, 1000),
            'tipopago' => $faker->randomElement(['contado', 'credito']),
            'saldopendiente' => $faker->randomFloat(2, 0, 500),
            'estado' => $faker->randomElement([1, 0]),
            'registradopor' => 'Seeder',
        ];
    }
}
