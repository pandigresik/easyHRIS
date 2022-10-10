<?php

namespace Database\Factories\Hr;

use App\Models\Hr\Payroll;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayrollFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payroll::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => $this->faker->word,
        'payroll_period_id' => $this->faker->word,
        'take_home_pay' => $this->faker->boolean,
        'take_home_pay_key' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
