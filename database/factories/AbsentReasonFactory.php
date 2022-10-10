<?php

namespace Database\Factories\Hr;

use App\Models\Hr\AbsentReason;
use Illuminate\Database\Eloquent\Factories\Factory;

class AbsentReasonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AbsentReason::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->lexify('?????'),
        'code' => $this->faker->text($this->faker->numberBetween(5, 7)),
        'name' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
