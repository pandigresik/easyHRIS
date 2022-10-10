<?php

namespace Database\Factories\Hr;

use App\Models\Hr\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contract_id' => $this->faker->word,
        'company_id' => $this->faker->word,
        'department_id' => $this->faker->word,
        'joblevel_id' => $this->faker->word,
        'jobtitle_id' => $this->faker->word,
        'supervisor_id' => $this->faker->word,
        'region_of_birth_id' => $this->faker->word,
        'city_of_birth_id' => $this->faker->word,
        'address' => $this->faker->text($this->faker->numberBetween(5, 255)),
        'join_date' => $this->faker->date('Y-m-d'),
        'employee_status' => $this->faker->lexify('?????'),
        'code' => $this->faker->text($this->faker->numberBetween(5, 17)),
        'full_name' => $this->faker->firstName,
        'gender' => $this->faker->lexify('?????'),
        'date_of_birth' => $this->faker->date('Y-m-d'),
        'identity_number' => $this->faker->text($this->faker->numberBetween(5, 27)),
        'identity_type' => $this->faker->lexify('?????'),
        'marital_status' => $this->faker->lexify('?????'),
        'email' => $this->faker->email,
        'leave_balance' => $this->faker->numberBetween(0, 999),
        'tax_group' => $this->faker->lexify('?????'),
        'resign_date' => $this->faker->date('Y-m-d'),
        'have_overtime_benefit' => $this->faker->boolean,
        'risk_ratio' => $this->faker->lexify('?????'),
        'profile_image' => $this->faker->text($this->faker->numberBetween(5, 255)),
        'profile_size' => $this->faker->numberBetween(0, 999),
        'salary_group_id' => $this->faker->word,
        'shiftment_group_id' => $this->faker->word
        ];
    }
}
