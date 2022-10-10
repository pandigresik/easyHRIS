<?php

namespace Database\Factories\Base;

use App\Models\Base\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'parent_id' => $this->faker->word,
        'address' => $this->faker->text($this->faker->numberBetween(5, 255)),
        'code' => $this->faker->text($this->faker->numberBetween(5, 7)),
        'name' => $this->faker->text($this->faker->numberBetween(5, 255)),
        'birth_day' => $this->faker->date('Y-m-d'),
        'email' => $this->faker->email,
        'tax_number' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
