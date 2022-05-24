<?php

namespace Database\Factories;

use App\Models\Route;
use Illuminate\Database\Eloquent\Factories\Factory;

class RouteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Route::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = now()->addWeek();
        return [
            'started_at' => now(),
            'deadline_at' => $this->faker->dateTimeBetween($date, $date->addWeek()),
            'activity_id' => $this->faker->numberBetween(1, 5)
        ];
    }
}
