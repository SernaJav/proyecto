<?php

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

class ProveedorFactory extends Factory
{
    protected $model = Proveedor::class;

    public function definition(): array
    {
        $faker = FakerFactory::create('es_ES');

        return [
            'nombre' => $faker->name(),
            'documento' => $faker->numerify('##########'),
            'direccion' => $faker->address(),
            'telefono' => $faker->phoneNumber(),
            'email' => $faker->unique()->safeEmail(),
            'estado' => 1,
            'registradopor' => 'Seeder',
        ];
    }
}
