<?php

namespace Database\Factories\Hr;

use App\Models\Hr\JobTitle;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobTitleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobTitle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'job_level_id' => $this->faker->word,
        'code' => $this->faker->text($this->faker->numberBetween(5, 9)),
        'name' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
