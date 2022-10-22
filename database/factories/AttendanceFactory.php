<?php

namespace Database\Factories\Hr;

use App\Models\Hr\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attendance::class;

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
        'reason_id' => $this->faker->word,
        'attendance_date' => $this->faker->date('Y-m-d'),
        'description' => $this->faker->text($this->faker->numberBetween(5, 255)),
        'check_in_schedule' => $this->faker->date('Y-m-d H:i:s'),
        'check_out_schedule' => $this->faker->date('Y-m-d H:i:s'),
        'check_in' => $this->faker->date('Y-m-d H:i:s'),
        'check_out' => $this->faker->date('Y-m-d H:i:s'),
        'early_in' => $this->faker->numberBetween(0, 999),
        'early_out' => $this->faker->numberBetween(0, 999),
        'late_in' => $this->faker->numberBetween(0, 999),
        'late_out' => $this->faker->numberBetween(0, 999),
        'absent' => $this->faker->boolean
        ];
    }
}
