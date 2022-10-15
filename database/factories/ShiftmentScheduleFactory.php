<?php

namespace Database\Factories\Hr;

use App\Models\Hr\ShiftmentSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShiftmentScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShiftmentSchedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'shiftment_id' => $this->faker->word,
        'work_day' => $this->faker->text($this->faker->numberBetween(5, 10)),
        'start_hour' => $this->faker->date('H:i:s'),
        'end_hour' => $this->faker->date('H:i:s')
        ];
    }
}
