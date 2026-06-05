<?php

namespace Database\Factories;

use App\Models\Pago;
use App\Models\OrdenCompra;
use App\Models\MetodoPago;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pago>
 */
class PagoFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = $this->faker ?? fake();

        return [
            'ordencompra_id' => $faker->randomElement(OrdenCompra::pluck('id')->toArray()),
            'fechapago' => $faker->dateTimeBetween('-90 days', 'now')->format('Y-m-d'),
            'monto' => $faker->randomFloat(2, 50, 500),
            'metodopago_id' => $faker->randomElement(MetodoPago::pluck('id')->toArray()),
            'registradopor' => 'Seeder',
        ];
    }
}
