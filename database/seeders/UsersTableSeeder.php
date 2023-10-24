<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'khamim',
            'email' => 'khamimthohari50@gmail.com',
            'password' => Hash::make('khamim123'),
            'role_id' => 1,
        ]);
        User::create([
            'name' => 'devi',
            'email' => 'anitadevi33@gmail.com',
            'password' => Hash::make('devi123'),
            'role_id' => 2,
        ]);
        
    }
}
