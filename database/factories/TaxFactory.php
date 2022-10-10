<?php

namespace Database\Factories\Accounting;

use App\Models\Accounting\Tax;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tax::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'period_id' => $this->faker->word,
        'employee_id' => $this->faker->word,
        'tax_group' => $this->faker->lexify('?????'),
        'untaxable' => $this->faker->boolean,
        'taxable' => $this->faker->boolean,
        'tax_value' => $this->faker->boolean,
        'tax_key' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
