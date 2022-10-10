<?php

namespace Database\Factories\Hr;

use App\Models\Hr\JobPlacement;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobPlacementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobPlacement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => $this->faker->word,
        'company_id' => $this->faker->word,
        'department_id' => $this->faker->word,
        'joblevel_id' => $this->faker->word,
        'jobtitle_id' => $this->faker->word,
        'supervisor_id' => $this->faker->word,
        'contract_id' => $this->faker->word,
        'active' => $this->faker->boolean
        ];
    }
}
