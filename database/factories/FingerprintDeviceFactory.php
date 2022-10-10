<?php

namespace Database\Factories\Hr;

use App\Models\Hr\FingerprintDevice;
use Illuminate\Database\Eloquent\Factories\Factory;

class FingerprintDeviceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FingerprintDevice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'serial_number' => $this->faker->text($this->faker->numberBetween(5, 50)),
        'ip' => $this->faker->text($this->faker->numberBetween(5, 30)),
        'display_name' => $this->faker->text($this->faker->numberBetween(5, 30))
        ];
    }
}
