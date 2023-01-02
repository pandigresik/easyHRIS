<?php

namespace Database\Factories\Base;

use App\Models\Base\Approval;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApprovalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Approval::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'model' => $this->faker->text($this->faker->numberBetween(5, 80)),
        'reference' => $this->faker->word,
        'status' => $this->faker->lexify('?????'),
        'comment' => $this->faker->text($this->faker->numberBetween(5, 255)),
        'sequence' => $this->faker->boolean,
        'user_id' => $this->faker->word
        ];
    }
}
