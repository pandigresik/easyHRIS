<?php

namespace Database\Factories\Hr;

use App\Models\Hr\Overtime;
use Illuminate\Database\Eloquent\Factories\Factory;

class OvertimeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Overtime::class;

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
        'approved_by_id' => $this->faker->word,
        'overtime_date' => $this->faker->date('Y-m-d'),
        'start_hour' => $this->faker->date('H:i:s'),
        'end_hour' => $this->faker->date('H:i:s'),
        'start_hour_real' => $this->faker->date('H:i:s'),
        'end_hour_real' => $this->faker->date('H:i:s'),
        'raw_value' => $this->faker->numberBetween(0, 999),
        'calculated_value' => $this->faker->numberBetween(0, 999),
        'holiday' => $this->faker->boolean,
        'overday' => $this->faker->boolean,
        'description' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
