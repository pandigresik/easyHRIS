<?php

namespace Database\Factories\Hr;

use App\Models\Hr\JobMutation;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobMutationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobMutation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => $this->faker->word,
        'old_company_id' => $this->faker->word,
        'old_department_id' => $this->faker->word,
        'old_joblevel_id' => $this->faker->word,
        'old_jobtitle_id' => $this->faker->word,
        'old_supervisor_id' => $this->faker->word,
        'new_company_id' => $this->faker->word,
        'new_department_id' => $this->faker->word,
        'new_joblevel_id' => $this->faker->word,
        'new_jobtitle_id' => $this->faker->word,
        'new_supervisor_id' => $this->faker->word,
        'contract_id' => $this->faker->word,
        'type' => $this->faker->lexify('?????')
        ];
    }
}
