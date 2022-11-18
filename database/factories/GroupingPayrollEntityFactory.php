<?php

namespace Database\Factories\Hr;

use App\Models\Hr\GroupingPayrollEntity;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupingPayrollEntityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GroupingPayrollEntity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->text($this->faker->numberBetween(5, 5)),
        'name' => $this->faker->text($this->faker->numberBetween(5, 50))
        ];
    }
}
