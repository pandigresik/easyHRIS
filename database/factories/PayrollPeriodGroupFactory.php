<?php

namespace Database\Factories\Hr;

use App\Models\Hr\PayrollPeriodGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayrollPeriodGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PayrollPeriodGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text($this->faker->numberBetween(5, 50)),
        'type_period' => $this->faker->text($this->faker->numberBetween(5, 4096)),
        'description' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
