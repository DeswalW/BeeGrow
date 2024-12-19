<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert project data
        $projectId = DB::table('projects')->insertGetId([
            'umkm_id' => 1,
            'title' => 'Proyek UMKM Contoh',
            'description' => 'Deskripsi proyek UMKM Contoh',
            'photo' => 'https://sl.bing.net/bwDTi0TwBsy',
            'status' => 'Sedang Berlangsung',
            'deadline' => Carbon::now()->addDays(30),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Insert funding details
        DB::table('funding_details')->insert([
            'project_id' => $projectId,
            'target_pendanaan' => 1000000,
            'dana_terkumpul' => 250000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Insert shares information
        DB::table('shares')->insert([
            'project_id' => $projectId,
            'harga_lembar_saham' => 10000,
            'jumlah_lembar_saham' => 100,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Insert investors information
        DB::table('investors')->insert([
            'project_id' => $projectId,
            'jumlah_investor' => 10,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}