<?php

namespace Database\Factories\Hr;

use App\Models\Hr\PayrollDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayrollDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PayrollDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'payroll_id' => $this->faker->word,
        'component_id' => $this->faker->word,
        'benefit_value' => $this->faker->boolean,
        'benefit_key' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
