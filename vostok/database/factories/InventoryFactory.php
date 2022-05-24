<?php

namespace Database\Factories;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Inventory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => $this->faker->numberBetween(1, 5),
            'title' => $this->faker->realText(200),
            'manufacturer_code' => $this->faker->numerify('ROJR ### ###/# R##'),
            'serial_number' => $this->faker->numerify('CR##L######')
        ];
    }
}
