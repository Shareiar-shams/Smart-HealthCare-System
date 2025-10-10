<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@healthcare.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin@123'),
                'role_id' => 1,
                'status' => 'Active',
            ]
        );

        $admin->assignRole('Super Admin');
    }
}
