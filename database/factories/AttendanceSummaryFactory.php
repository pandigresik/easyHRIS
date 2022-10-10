<?php

namespace Database\Factories\Hr;

use App\Models\Hr\AttendanceSummary;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceSummaryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AttendanceSummary::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => $this->faker->word,
        'year' => $this->faker->word,
        'month' => $this->faker->word,
        'total_workday' => $this->faker->numberBetween(0, 999),
        'total_in' => $this->faker->numberBetween(0, 999),
        'total_loyality' => $this->faker->numberBetween(0, 999),
        'total_absent' => $this->faker->numberBetween(0, 999),
        'total_overtime' => $this->faker->numberBetween(0, 999)
        ];
    }
}
