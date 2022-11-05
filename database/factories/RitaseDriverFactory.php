<?php

namespace Database\Factories\Hr;

use App\Models\Hr\RitaseDriver;
use Illuminate\Database\Eloquent\Factories\Factory;

class RitaseDriverFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RitaseDriver::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => $this->faker->word,
        'work_date' => $this->faker->date('Y-m-d'),
        'km' => $this->faker->word,
        'double_rit' => $this->faker->boolean
        ];
    }
}
