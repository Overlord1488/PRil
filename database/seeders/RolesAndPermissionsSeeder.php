<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage products',
            'manage categories',
            'manage trainers',
            'manage directions',
            'manage orders',
            'manage bookings',
            'manage users',
            'manage reviews',
            'view trainer dashboard',
            'manage own schedule',
            'view own bookings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $guest = Role::firstOrCreate(['name' => 'guest']);
        $client = Role::firstOrCreate(['name' => 'client']);
        $trainer = Role::firstOrCreate(['name' => 'trainer']);
        $admin = Role::firstOrCreate(['name' => 'admin']);

        $trainer->givePermissionTo(['view trainer dashboard', 'manage own schedule', 'view own bookings']);
        $admin->givePermissionTo(Permission::all());

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gymhub.local'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin12345!'),
                'email_verified_at' => now(),
            ]
        );
        $adminUser->assignRole('admin');
    }
}
