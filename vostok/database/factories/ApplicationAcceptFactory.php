<?php

namespace Database\Factories;

use App\Models\ApplicationAccept;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationAcceptFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApplicationAccept::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'comment' => $this->faker->text,
        ];
    }
}
