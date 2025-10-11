<?php

namespace Database\Seeders;

use App\Models\Viewport\BloodRequest\BloodRequest;
use App\Models\Viewport\Donor\Donor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BloodDonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $divisions = ['Dhaka', 'Chattogram', 'Rajshahi', 'Khulna', 'Barishal', 'Sylhet', 'Rangpur', 'Mymensingh'];
        $districts = [
            'Dhaka' => ['Dhaka', 'Gazipur', 'Narayanganj', 'Tangail'],
            'Chattogram' => ['Chattogram', 'Cox\'s Bazar', 'Rangamati', 'Bandarban'],
            'Rajshahi' => ['Rajshahi', 'Bogra', 'Pabna', 'Sirajganj'],
            'Khulna' => ['Khulna', 'Jessore', 'Satkhira', 'Bagerhat'],
            'Barishal' => ['Barishal', 'Patuakhali', 'Bhola', 'Jhalokati'],
            'Sylhet' => ['Sylhet', 'Moulvibazar', 'Habiganj', 'Sunamganj'],
            'Rangpur' => ['Rangpur', 'Dinajpur', 'Nilphamari', 'Gaibandha'],
            'Mymensingh' => ['Mymensingh', 'Jamalpur', 'Netrokona', 'Sherpur']
        ];
        
        // Create sample donors
        for ($i = 0; $i < 150; $i++) {
            $division = $divisions[array_rand($divisions)];
            $divisionDistricts = $districts[$division];
            
            Donor::create([
                'name' => 'Donor ' . ($i + 1),
                'email' => 'donor' . ($i + 1) . '@example.com',
                'phone' => '01' . rand(300000000, 999999999),
                'blood_group' => $bloodGroups[array_rand($bloodGroups)],
                'division' => $division,
                'district' => $divisionDistricts[array_rand($divisionDistricts)],
                'last_donation' => rand(0, 1) ? now()->subDays(rand(1, 180))->format('Y-m-d') : null,
                'health_conditions' => rand(0, 1) ? 'No known health conditions' : null,
                'availability' => rand(0, 1),
                'is_verified' => rand(0, 1),
                'created_at' => now()->subDays(rand(1, 365)),
                'updated_at' => now()->subDays(rand(1, 365))
            ]);
        }

        // Create sample blood requests
        for ($i = 0; $i < 50; $i++) {
            $division = $divisions[array_rand($divisions)];
            $divisionDistricts = $districts[$division];
            
            BloodRequest::create([
                'patient_name' => 'Patient ' . ($i + 1),
                'contact_person' => 'Contact Person ' . ($i + 1),
                'phone' => '01' . rand(300000000, 999999999),
                'hospital' => 'City Hospital ' . ($i + 1),
                'blood_group' => $bloodGroups[array_rand($bloodGroups)],
                'units_required' => rand(1, 4),
                'urgency' => ['low', 'medium', 'high', 'critical'][array_rand(['low', 'medium', 'high', 'critical'])],
                'division' => $division,
                'district' => $divisionDistricts[array_rand($divisionDistricts)],
                'required_date' => now()->addDays(rand(1, 30))->format('Y-m-d'),
                'gratitude_fee' => rand(500, 5000),
                'additional_info' => rand(0, 1) ? 'Urgent need for surgery' : null,
                'status' => ['pending', 'matched', 'fulfilled', 'cancelled'][array_rand(['pending', 'matched', 'fulfilled', 'cancelled'])],
                'created_at' => now()->subDays(rand(1, 90)),
                'updated_at' => now()->subDays(rand(1, 90))
            ]);
        }

        $this->command->info('Blood donation sample data created successfully!');
        $this->command->info('Donors created: ' . Donor::count());
        $this->command->info('Blood requests created: ' . BloodRequest::count());
    }
}
