<?php

namespace Database\Factories\Base;

use App\Models\Base\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Department::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'parent_id' => $this->faker->word,
        'code' => $this->faker->text($this->faker->numberBetween(5, 7)),
        'name' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
