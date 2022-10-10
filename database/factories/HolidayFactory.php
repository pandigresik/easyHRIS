<?php

namespace Database\Factories\Hr;

use App\Models\Hr\Holiday;
use Illuminate\Database\Eloquent\Factories\Factory;

class HolidayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Holiday::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'holiday_date' => $this->faker->date('Y-m-d'),
        'name' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
