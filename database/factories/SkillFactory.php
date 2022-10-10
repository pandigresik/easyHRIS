<?php

namespace Database\Factories\Hr;

use App\Models\Hr\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Skill::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'skill_group_id' => $this->faker->word,
        'name' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}
