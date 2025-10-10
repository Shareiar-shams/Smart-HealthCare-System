<?php

namespace Database\Seeders;

use App\Models\PermissionModule;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleManagementPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles Management module
        $rolesModule = PermissionModule::create(['name' => 'Roles']);

        // Create role management permissions
        $permissions = [
            'Role Everything' => 'Full control over roles',
            'Role Create' => 'Can create new roles',
            'Role Read' => 'Can view roles',
            'Role Update' => 'Can update roles',
            'Role Delete' => 'Can delete roles'
        ];

        foreach ($permissions as $permission => $description) {
            Permission::create([
                'name' => $permission,
                'permission_module_id' => $rolesModule->id
            ]);
        }

        // Ensure super_admin role exists and has these permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(array_keys($permissions));

        // If you're testing, optionally assign these permissions to existing roles
        $doctorRole = Role::where('name', 'doctor')->first();
        if ($doctorRole) {
            $doctorRole->givePermissionTo(['Role Read']);
        }

        // Create a test admin user if needed
        if (!\App\Models\User::where('email', 'admin@example.com')->exists()) {
            $admin = \App\Models\User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password')
            ]);
            $admin->assignRole('super_admin');
        }
    }
}