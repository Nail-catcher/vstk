<?php

namespace Database\Factories;

use App\Models\Address;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText(random_int(15, 45)),
            'address' => $this->faker->address,
            'cost' => $this->faker->randomFloat(2, 120, 1045),
            'location' => new Point($this->faker->longitude, $this->faker->latitude)
        ];
    }
}
