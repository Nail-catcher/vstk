<?php

namespace Database\Factories;

use App\Models\RouteLocation;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

class RouteLocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RouteLocation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'location' => new Point($this->faker->latitude, $this->faker->longitude)
        ];
    }
}
