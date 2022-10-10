<?php

namespace Database\Factories\Hr;

use App\Models\Hr\AttendanceLogfinger;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceLogfingerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AttendanceLogfinger::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => $this->faker->word,
        'type_absen' => $this->faker->lexify('?????'),
        'fingertime' => $this->faker->date('Y-m-d H:i:s'),
        'fingerprint_device_id' => $this->faker->word
        ];
    }
}
