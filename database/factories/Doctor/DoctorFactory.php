<?php

namespace Database\Factories\Doctor;

use App\Models\Doctor\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition(): array
    {
        return [
            'specialty' => fake()->randomElement([
                'Cardiology', 'Dermatology', 'Endocrinology', 'Gastroenterology',
                'Neurology', 'Oncology', 'Pediatrics', 'Psychiatry', 'Surgery'
            ]),
            'qualification' => fake()->randomElement([
                'MBBS', 'MD', 'MS', 'DNB', 'DM', 'MCh'
            ]) . ', ' . fake()->randomElement(['FRCS', 'MRCP', 'FACS']),
            'experience_years' => fake()->numberBetween(1, 30),
            'license_number' => fake()->unique()->numerify('DOC-####-###'),
            'consultation_fee' => fake()->numberBetween(500, 2000),
            'available_days' => json_encode(fake()->randomElements(
                ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                fake()->numberBetween(3, 6)
            )),
            'available_time' => json_encode([
                'start' => fake()->time('H:i'),
                'end' => fake()->time('H:i')
            ]),
            'bio' => fake()->paragraph(3),
        ];
    }
}