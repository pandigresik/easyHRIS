<?php

namespace Database\Factories\Hr;

use App\Models\Hr\GroupingPayrollEmployeeReport;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupingPayrollEmployeeReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GroupingPayrollEmployeeReport::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => $this->faker->word,
        'grouping_payroll_entity_id' => $this->faker->word
        ];
    }
}
