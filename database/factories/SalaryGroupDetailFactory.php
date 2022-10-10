<?php

namespace Database\Factories\Hr;

use App\Models\Hr\SalaryGroupDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryGroupDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalaryGroupDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'component_id' => $this->faker->word,
        'salary_group_id' => $this->faker->word,
        'component_value' => $this->faker->boolean
        ];
    }
}
