<?php

namespace Database\Factories\Hr;

use App\Models\Hr\EmployeeShiftment;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeShiftmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployeeShiftment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => $this->faker->word,
        'shiftment_group_id' => $this->faker->word,
        'active' => $this->faker->lexify('?????')
        ];
    }
}
