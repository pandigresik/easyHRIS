<?php

namespace Database\Factories\Hr;

use App\Models\Hr\SalaryBenefitHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryBenefitHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalaryBenefitHistory::class;

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
        'contract_id' => $this->faker->word,
        'new_benefit_value' => $this->faker->boolean,
        'old_benefit_value' => $this->faker->boolean,
        'benefit_key' => $this->faker->text($this->faker->numberBetween(5, 255)),
        'description' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
