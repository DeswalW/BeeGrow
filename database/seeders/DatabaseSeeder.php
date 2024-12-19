<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Laravolt\Indonesia\Seeds\CitiesSeeder;
use Laravolt\Indonesia\Seeds\VillagesSeeder;
use Laravolt\Indonesia\Seeds\DistrictsSeeder;
use Laravolt\Indonesia\Seeds\ProvincesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'), // Enkripsi password
        ]);

        $this->call([
            RoleAndPermissionSeeder::class,
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Enkripsi password
        ]);
        $admin->assignRole('admin');

        $umkm = User::factory()->create([
            'name' => 'UMKM User',
            'email' => 'umkm@example.com',
            'password' => Hash::make('password'), // Enkripsi password
        ]);
        $umkm->assignRole('umkm');

        $investor = User::factory()->create([
            'name' => 'Investor User',
            'email' => 'investor@example.com',
            'password' => Hash::make('password'), // Enkripsi password
        ]);
        $investor->assignRole('investor');

        $this->call([
            ProvincesSeeder::class,
            CitiesSeeder::class,
            DistrictsSeeder::class,
            VillagesSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
