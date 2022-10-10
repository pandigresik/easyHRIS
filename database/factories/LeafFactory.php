<?php

namespace Database\Factories\Hr;

use App\Models\Hr\Leaf;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeafFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Leaf::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => $this->faker->word,
        'reason_id' => $this->faker->word,
        'leave_date' => $this->faker->date('Y-m-d'),
        'amount' => $this->faker->word,
        'description' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
