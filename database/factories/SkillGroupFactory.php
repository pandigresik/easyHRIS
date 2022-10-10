<?php

namespace Database\Factories\Hr;

use App\Models\Hr\SkillGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SkillGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'parent_id' => $this->faker->word,
        'name' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
