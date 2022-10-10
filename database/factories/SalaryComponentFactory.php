<?php

namespace Database\Factories\Hr;

use App\Models\Hr\SalaryComponent;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryComponentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalaryComponent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->text($this->faker->numberBetween(5, 7)),
        'name' => $this->faker->text($this->faker->numberBetween(5, 255)),
        'state' => $this->faker->lexify('?????'),
        'fixed' => $this->faker->boolean
        ];
    }
}
