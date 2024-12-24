<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'umkm_id' => 1,
                'title' => 'Ekspansi Warung Bu Siti',
                'description' => 'Pendanaan untuk membuka cabang baru dan mengembangkan dapur produksi.',
                'photo' => 'https://example.com/warung.jpg',
                'status' => 'Sedang Berlangsung',
                'target_pendanaan' => 50000000,
            ],
            [
                'umkm_id' => 2,
                'title' => 'Modernisasi Alat Produksi Bambu',
                'description' => 'Pengadaan mesin modern untuk meningkatkan kapasitas produksi kerajinan bambu.',
                'photo' => 'https://example.com/bambu.jpg',
                'status' => 'Sedang Berlangsung',
                'target_pendanaan' => 75000000,
            ],
            [
                'umkm_id' => 3,
                'title' => 'Pengembangan Workshop Batik',
                'description' => 'Pembangunan workshop baru dan pelatihan pembatik muda.',
                'photo' => 'https://example.com/batik.jpg',
                'status' => 'Sedang Berlangsung',
                'target_pendanaan' => 100000000,
            ],
            [
                'umkm_id' => 4,
                'title' => 'Ekspansi Produksi Kopi Gayo',
                'description' => 'Peningkatan kapasitas produksi dan pembukaan coffee shop.',
                'photo' => 'https://example.com/kopi.jpg',
                'status' => 'Sedang Berlangsung',
                'target_pendanaan' => 150000000,
            ],
        ];

        foreach ($projects as $project) {
            $targetPendanaan = $project['target_pendanaan'];
            unset($project['target_pendanaan']);

            // Insert project
            $projectId = DB::table('projects')->insertGetId(array_merge($project, [
                'deadline' => Carbon::now()->addDays(90),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));

            // Insert funding details
            DB::table('funding_details')->insert([
                'project_id' => $projectId,
                'target_pendanaan' => $targetPendanaan,
                'dana_terkumpul' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Insert shares information
            DB::table('shares')->insert([
                'project_id' => $projectId,
                'harga_lembar_saham' => 10000,
                'jumlah_lembar_saham' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Insert investors information
            DB::table('investors')->insert([
                'project_id' => $projectId,
                'jumlah_investor' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}