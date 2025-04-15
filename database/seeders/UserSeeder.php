<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Ramon Hidayat',
            'email' => 'hidayatmramon@gmail.com',
            'role' => 'admin',
            'password' => bcrypt(1122),
         ]);
    }
}

