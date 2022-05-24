<?php

namespace Database\Factories;

use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = $this->faker->numberBetween(1, 4);
        $type = $this->faker->numberBetween(1, 2);
        $started_at = $this->faker->dateTimeBetween('now', '+3 months');
        $deadline_at = $this->faker->dateTimeBetween('+1 week', '+3 months');
        $ended_at = $this->faker->dateTimeBetween($started_at, '+3 months');
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'engineer_id' => $this->faker->numberBetween(1, 10),
            'project_id' => $this->faker->numberBetween(1, 2),
            'type_id' => $this->faker->numberBetween(1, 2),
            'status_id' => $status,
            'ticket' => ($type === 1) ? $this->faker->numerify('AL#####') : null,
            'document' => $this->faker->numerify('####/У-ВТК'),
            'priority' => $this->faker->randomElement(['critical', 'major', 'minor']),
            'description' => $this->faker->realText(),
            'comment' => $this->faker->realText(),
            'distance' => $this->faker->randomFloat('2', '1000', '120000'),
            'started_at' => ($status > 2) ? $started_at : null,
            'ended_at' => ($status === 4) ? $ended_at : null,
            'deadline_at' => $deadline_at
        ];
    }
}
