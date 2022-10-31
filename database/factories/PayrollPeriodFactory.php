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
        'name' => $this->faker->text($this->faker->numberBetween(5, 255)),
        'year' => $this->faker->word,
        'month' => $this->faker->word,
        'start_period' => $this->faker->date('Y-m-d'),
        'end_period' => $this->faker->date('Y-m-d'),
        'closed' => $this->faker->boolean
        ];
    }
}
