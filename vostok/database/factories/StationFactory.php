<?php

namespace Database\Factories;

use App\Models\Station;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

class StationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Station::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'city_id' => $this->faker->numberBetween(1, 5),
            'bts_id' => $this->faker->numerify('AL####'),
            'address' => $this->faker->address,
            'location' => new Point($this->faker->longitude, $this->faker->latitude, '4326')
        ];
    }
}
