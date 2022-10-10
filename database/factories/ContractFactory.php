<?php

namespace Database\Factories\Hr;

use App\Models\Hr\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contract::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->lexify('?????'),
        'letter_number' => $this->faker->text($this->faker->numberBetween(5, 27)),
        'subject' => $this->faker->text($this->faker->numberBetween(5, 255)),
        'description' => $this->faker->text($this->faker->numberBetween(5, 255)),
        'start_date' => $this->faker->date('Y-m-d'),
        'end_date' => $this->faker->date('Y-m-d'),
        'signed_date' => $this->faker->date('Y-m-d'),
        'tags' => $this->faker->boolean,
        'used' => $this->faker->boolean
        ];
    }
}
