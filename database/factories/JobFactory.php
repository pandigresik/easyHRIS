<?php

namespace Database\Factories\Utility;

use App\Models\Utility\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'queue' => $this->faker->text($this->faker->numberBetween(5, 255)),
        'payload' => $this->faker->boolean,
        'attempts' => $this->faker->boolean,
        'reserved_at' => $this->faker->numberBetween(0, 999),
        'available_at' => $this->faker->numberBetween(0, 999)
        ];
    }
}
