<?php

namespace Database\Factories\Base;

use App\Models\Base\BusinessUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessUnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BusinessUnit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->text($this->faker->numberBetween(5, 10)),
        'name' => $this->faker->text($this->faker->numberBetween(5, 50))
        ];
    }
}
