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
        $umkms = [
            [
                'user_id' => 1,
                'name' => 'Warung Makan Bu Siti',
                'description' => 'Warung makan tradisional dengan menu khas Sunda yang telah berdiri sejak 2010.',
                'contact' => '08123456789',
                'address' => 'Jl. Raya Bogor No. 123, Bogor',
                'gmaps' => 'https://maps.google.com/?q=Jl.+Raya+Bogor+No.+123',
            ],
            [
                'user_id' => 2,
                'name' => 'Kerajinan Bambu Pak Hadi',
                'description' => 'Pengrajin bambu yang menghasilkan berbagai produk furniture dan dekorasi rumah.',
                'contact' => '087654321098',
                'address' => 'Jl. Veteran No. 45, Bandung',
                'gmaps' => 'https://maps.google.com/?q=Jl.+Veteran+No.+45+Bandung',
            ],
            [
                'user_id' => 3,
                'name' => 'Batik Pesisir Collection',
                'description' => 'Produsen batik pesisir dengan motif khas yang telah diekspor ke berbagai negara.',
                'contact' => '081234567890',
                'address' => 'Jl. Pasar Baru No. 78, Pekalongan',
                'gmaps' => 'https://maps.google.com/?q=Jl.+Pasar+Baru+No.+78+Pekalongan',
            ],
            [
                'user_id' => 4,
                'name' => 'Kopi Arabika Gayo',
                'description' => 'Pengolah dan distributor kopi Arabika Gayo premium dari Aceh.',
                'contact' => '089876543210',
                'address' => 'Jl. Iskandar Muda No. 90, Takengon',
                'gmaps' => 'https://maps.google.com/?q=Jl.+Iskandar+Muda+No.+90+Takengon',
            ],
        ];

        foreach ($umkms as $umkm) {
            DB::table('umkms')->insert(array_merge($umkm, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }

        // Kategori untuk setiap UMKM
        $categories = [1, 2, 3, 4]; // Sesuaikan dengan ID kategori yang ada
        foreach (range(1, 4) as $umkmId) {
            DB::table('category_umkm')->insert([
                'umkm_id' => $umkmId,
                'category_id' => $categories[$umkmId-1],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
