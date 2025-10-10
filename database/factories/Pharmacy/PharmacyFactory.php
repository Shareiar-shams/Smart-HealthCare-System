<?php

namespace Database\Factories\Pharmacy;

use App\Models\Pharmacy\Pharmacy;
use Illuminate\Database\Eloquent\Factories\Factory;

class PharmacyFactory extends Factory
{
    protected $model = Pharmacy::class;

    public function definition(): array
    {
        return [
            'pharmacy_name' => fake()->company() . ' Pharmacy',
            'license_number' => fake()->unique()->numerify('PHAR-####-###'),
            'contact_no' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'postal_code' => fake()->postcode(),
            'opening_hours' => json_encode([
                'weekdays' => '9:00 AM - 9:00 PM',
                'weekends' => '10:00 AM - 6:00 PM'
            ]),
            'delivery_available' => fake()->boolean(80),
            'emergency_service' => fake()->boolean(40),
            'description' => fake()->paragraph(2),
        ];
    }
}