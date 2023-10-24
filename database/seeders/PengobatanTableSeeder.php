<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengobatan;

class PengobatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pengobatan::create([
            'pengobatan' => 'minum obat',
            'level_penyakit' => '1'
        ]);
       
    }
}
