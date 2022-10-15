<?php

namespace Database\Factories\Hr;

use App\Models\Hr\WorkshiftGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkshiftGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkshiftGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'shiftment_group_id' => $this->faker->word,
        'shiftment_id' => $this->faker->word,
        'work_date' => $this->faker->date('Y-m-d')
        ];
    }
}
