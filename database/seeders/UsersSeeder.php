<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Eduardo Admin',
            'email' => 'admin@revico.com',
            'password' => bcrypt('senha123'),
            'role' => 'admin',
        ]);

        // Revisores
        User::create([
            'name' => 'Eduardo Revisor',
            'email' => 'revisor@revico.com',
            'password' => bcrypt('senha123'),
            'role' => 'revisor',
        ]);

        User::create([
            'name' => 'Joana Revisora',
            'email' => 'revisor2@revico.com',
            'password' => bcrypt('senha123'),
            'role' => 'revisor',
        ]);

        User::create([
            'name' => 'Carlos Revisor',
            'email' => 'revisor3@revico.com',
            'password' => bcrypt('senha123'),
            'role' => 'revisor',
        ]);
    }
}