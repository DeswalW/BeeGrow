<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UmkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('umkms')->insert([
            'user_id' => 1,
            'name' => 'UMKM Contoh',
            'description' => 'Ini adalah deskripsi untuk UMKM Contoh.',
            'contact' => '08123456789',
            'address' => 'Jl. Contoh No. 123, Jakarta',
            'gmaps' => 'https://maps.google.com/?q=Jl.+Contoh+No.+123,+Jakarta', // Contoh URL Google Maps
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('category_umkm')->insert([
            'umkm_id' => 1,
            'category_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
