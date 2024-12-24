<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Bersihkan cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat role jika belum ada
        $roles = ['admin', 'investor', 'umkm'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Buat permissions jika diperlukan
        $permissions = [
            'manage users',
            'manage projects',
            'view reports'
            // tambahkan permission lain yang diperlukan
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions ke role
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo(Permission::all());
    }
}