<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Edicao;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Eduardo Admin',
            'email' => 'admin@revistaavico.com',
            'password' => bcrypt('senha123'),
            'role' => 'admin',
        ]);
    }
}