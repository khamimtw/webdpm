<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Level::create([
            'level_penyakit' => 'Tidak Terkena Hypertiroid',
        ]);
        Level::create([
            'level_penyakit' => 'Ringan',
        ]);
        Level::create([
            'level_penyakit' => 'Sedang',
        ]);
        Level::create([
            'level_penyakit' => 'Berat',
        ]);
    }
}
