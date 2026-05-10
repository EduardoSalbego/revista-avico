<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Autor;
use App\Models\Revisor;
use App\Models\Leitor;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    public function run()
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        $admin = User::create([
            'name' => 'Eduardo Admin',
            'email' => 'admin@revico.com',
            'password' => bcrypt('senha123'),
        ]);

        $admin->assignRole('admin');

        /*
        |--------------------------------------------------------------------------
        | EDITOR
        |--------------------------------------------------------------------------
        */

        $editor = User::create([
            'name' => 'Editor REVICO',
            'email' => 'editor@revico.com',
            'password' => bcrypt('senha123'),
        ]);

        $editor->assignRole('editor');

        /*
        |--------------------------------------------------------------------------
        | REVISORES
        |--------------------------------------------------------------------------
        */

        $revisor1 = User::create([
            'name' => 'Eduardo Revisor',
            'email' => 'revisor@revico.com',
            'password' => bcrypt('senha123'),
        ]);

        Revisor::create([
            'user_id' => $revisor1->id,
        ]);


        $revisor2 = User::create([
            'name' => 'Joana Revisora',
            'email' => 'revisor2@revico.com',
            'password' => bcrypt('senha123'),
        ]);

        Revisor::create([
            'user_id' => $revisor2->id,
        ]);


        $revisor3 = User::create([
            'name' => 'Carlos Revisor',
            'email' => 'revisor3@revico.com',
            'password' => bcrypt('senha123'),
        ]);

        Revisor::create([
            'user_id' => $revisor3->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | AUTORES
        |--------------------------------------------------------------------------
        */

        $autor = User::create([
            'name' => 'Marina Autora',
            'email' => 'autor@revico.com',
            'password' => bcrypt('senha123'),
        ]);

        Autor::create([
            'user_id' => $autor->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | LEITOR
        |--------------------------------------------------------------------------
        */

        $leitor = User::create([
            'name' => 'Leitor Teste',
            'email' => 'leitor@revico.com',
            'password' => bcrypt('senha123'),
        ]);

        Leitor::create([
            'user_id' => $leitor->id,
        ]);
    }
}