<?php

namespace Database\Factories\Hr;

use App\Models\Hr\ShiftmentGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShiftmentGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShiftmentGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->text($this->faker->numberBetween(5, 7)),
        'company_id' => $this->faker->word,
        'name' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
