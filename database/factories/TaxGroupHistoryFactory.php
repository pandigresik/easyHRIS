<?php

namespace Database\Factories\Accounting;

use App\Models\Accounting\TaxGroupHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxGroupHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TaxGroupHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => $this->faker->word,
        'old_tax_group' => $this->faker->lexify('?????'),
        'new_tax_group' => $this->faker->lexify('?????'),
        'old_risk_ratio' => $this->faker->lexify('?????'),
        'new_risk_ratio' => $this->faker->lexify('?????')
        ];
    }
}
