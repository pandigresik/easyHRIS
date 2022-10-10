<?php

namespace Database\Factories\Hr;

use App\Models\Hr\PayrollPeriod;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayrollPeriodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PayrollPeriod::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => $this->faker->word,
        'year' => $this->faker->word,
        'month' => $this->faker->word,
        'closed' => $this->faker->boolean
        ];
    }
}
