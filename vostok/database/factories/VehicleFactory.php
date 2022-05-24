<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'model' => $this->faker->realText(random_int(15, 45)),
            'summer' => $this->faker->randomFloat(2, 2, 20),
            'winter' => $this->faker->randomFloat(2, 4, 30),
            'region' => $this->faker->randomFloat(2, 1, 30),
        ];
    }
}
