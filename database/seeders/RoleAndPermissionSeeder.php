<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $umkm = Role::create(['name' => 'umkm']);
        $investor = Role::create(['name' => 'investor']);

        Permission::create(['name' => 'manage projects']);
        Permission::create(['name' => 'invest in projects']);

        $admin->givePermissionTo(['manage projects', 'invest in projects']);
        $umkm->givePermissionTo('manage projects');
        $investor->givePermissionTo('invest in projects');
    }
}