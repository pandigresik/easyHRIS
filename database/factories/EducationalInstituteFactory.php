<?php

namespace Database\Factories\Hr;

use App\Models\Hr\EducationalInstitute;
use Illuminate\Database\Eloquent\Factories\Factory;

class EducationalInstituteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EducationalInstitute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
