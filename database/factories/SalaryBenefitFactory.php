<?php

namespace Database\Factories\Hr;

use App\Models\Hr\SalaryBenefit;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryBenefitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalaryBenefit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => $this->faker->word,
        'component_id' => $this->faker->word,
        'benefit_value' => $this->faker->boolean,
        'benefit_key' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
