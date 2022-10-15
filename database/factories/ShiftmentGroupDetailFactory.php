<?php

namespace Database\Factories\Hr;

use App\Models\Hr\ShiftmentGroupDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShiftmentGroupDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShiftmentGroupDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'shiftment_group_id' => $this->faker->word,
        'shiftment_id' => $this->faker->word,
        'sequence' => $this->faker->boolean
        ];
    }
}
