<?php

namespace Database\Factories\Utility;

use App\Models\Utility\FailedJob;
use Illuminate\Database\Eloquent\Factories\Factory;

class FailedJobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FailedJob::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'connection' => $this->faker->boolean,
        'queue' => $this->faker->boolean,
        'payload' => $this->faker->boolean,
        'exception' => $this->faker->boolean,
        'failed_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
