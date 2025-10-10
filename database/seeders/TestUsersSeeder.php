<?php

namespace Database\Seeders;

use App\Models\Doctor\Doctor;
use App\Models\Pharmacy\Pharmacy;
use App\Models\User;
use App\Models\UserProfile\UserProfile;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some test doctors
        $this->createDoctors();

        // Create some test pharmacists
        $this->createPharmacists();

        // Create some test patients
        $this->createPatients();
    }

    /**
     * Create test doctors with their profiles
     */
    private function createDoctors(): void
    {
        $doctorRole = Role::where('name', 'Doctor')->first();
        
        // Create 5 doctors
        User::factory()
            ->count(5)
            ->create()
            ->each(function ($user) use ($doctorRole) {
                // Assign doctor role
                $user->assignRole($doctorRole);
                $user->update(['role_id' => $doctorRole->id]);

                // Create profile
                UserProfile::factory()->create([
                    'user_id' => $user->id
                ]);

                // Create doctor details
                Doctor::factory()->create([
                    'user_id' => $user->id
                ]);
            });
    }

    /**
     * Create test pharmacists with their profiles
     */
    private function createPharmacists(): void
    {
        $pharmacistRole = Role::where('name', 'Pharmacy')->first();
        
        // Create 3 pharmacists
        User::factory()
            ->count(3)
            ->create()
            ->each(function ($user) use ($pharmacistRole) {
                // Assign pharmacist role
                $user->assignRole($pharmacistRole);
                $user->update(['role_id' => $pharmacistRole->id]);

                // Create profile
                UserProfile::factory()->create([
                    'user_id' => $user->id
                ]);

                // Create pharmacy details
                Pharmacy::factory()->create([
                    'user_id' => $user->id
                ]);
            });
    }

    /**
     * Create test patients with their profiles
     */
    private function createPatients(): void
    {
        $patientRole = Role::where('name', 'Patient')->first();
        
        // Create 10 patients
        User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) use ($patientRole) {
                // Assign patient role
                $user->assignRole($patientRole);
                $user->update(['role_id' => $patientRole->id]);

                // Create profile
                UserProfile::factory()->create([
                    'user_id' => $user->id
                ]);
            });
    }
}