<?php

namespace Database\Factories\Hr;

use App\Models\Hr\EducationTitle;
use Illuminate\Database\Eloquent\Factories\Factory;

class EducationTitleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EducationTitle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'short_name' => $this->faker->lastName,
        'name' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
