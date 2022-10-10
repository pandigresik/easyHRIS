<?php

namespace Database\Factories\Hr;

use App\Models\Hr\JobLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobLevelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobLevel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'parent_id' => $this->faker->word,
        'code' => $this->faker->text($this->faker->numberBetween(5, 7)),
        'name' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
