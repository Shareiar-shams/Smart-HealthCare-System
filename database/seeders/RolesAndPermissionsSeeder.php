<?php

namespace Database\Seeders;

use App\Models\PermissionModule;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permission modules
        $moduleNames = ['Users', 'Doctors', 'Patients', 'Pharmacies', 'Appointments', 'Prescriptions'];
        $modules = collect($moduleNames)->map(function ($name) {
            return PermissionModule::create(['name' => $name]);
        });

        // Create permissions for each module
        $modules->each(function ($module) {
            $actions = ['view', 'create', 'edit', 'delete'];
            foreach ($actions as $action) {
                Permission::create([
                    'name' => strtolower($action . ' ' . $module->name),
                    'permission_module_id' => $module->id
                ]);
            }
        });

        // Create roles
        $roles = [
            'doctor' => [
                'view Doctors', 'edit Doctors',
                'view Patients', 'create Patients', 'edit Patients',
                'view Appointments', 'create Appointments', 'edit Appointments',
                'view Prescriptions', 'create Prescriptions', 'edit Prescriptions'
            ],
            'pharmacist' => [
                'view Pharmacies', 'edit Pharmacies',
                'view Prescriptions', 'edit Prescriptions'
            ],
            'patient' => [
                'view Doctors',
                'view Appointments', 'create Appointments',
                'view Prescriptions'
            ]
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::create(['name' => $roleName]);
            $role->givePermissionTo($permissions);
        }
    }
}