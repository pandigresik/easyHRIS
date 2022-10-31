<?php

namespace Database\Factories\Hr;

use App\Models\Hr\RequestWorkshift;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequestWorkshiftFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RequestWorkshift::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => $this->faker->word,
        'shiftment_id' => $this->faker->word,
        'shiftment_id_origin' => $this->faker->word,
        'work_date' => $this->faker->date('Y-m-d'),
        'status' => $this->faker->lexify('?????'),
        'description' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
