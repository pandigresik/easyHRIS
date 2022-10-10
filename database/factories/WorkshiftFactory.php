<?php

namespace Database\Factories\Hr;

use App\Models\Hr\Workshift;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkshiftFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Workshift::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => $this->faker->word,
        'shiftment_id' => $this->faker->word,
        'description' => $this->faker->text($this->faker->numberBetween(5, 255)),
        'work_date' => $this->faker->date('Y-m-d')
        ];
    }
}
