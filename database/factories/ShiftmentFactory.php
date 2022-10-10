<?php

namespace Database\Factories\Hr;

use App\Models\Hr\Shiftment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShiftmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shiftment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->text($this->faker->numberBetween(5, 7)),
        'name' => $this->faker->text($this->faker->numberBetween(5, 255)),
        'start_hour' => $this->faker->date('H:i:s'),
        'end_hour' => $this->faker->date('H:i:s')
        ];
    }
}
