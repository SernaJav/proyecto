<?php

namespace Database\Factories;

use App\Models\MetodoPago;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MetodoPago>
 */
class MetodoPagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = $this->faker ?? fake();
        $metodos = [
            'Efectivo',
            'Transferencia',
            'Tarjeta Débito',
            'Tarjeta Crédito',
            'Nequi',
            'Daviplata'
        ];

        return [
            'nombre' => $faker->unique()->randomElement($metodos),
            'descripcion' => $faker->sentence(),
            'estado' => 1,
            'registradopor' => 'Seeder',
        ];
    }
}
