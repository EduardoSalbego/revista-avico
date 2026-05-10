<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissões granulares
        $permissions = [
            // Edições
            'edicoes.criar', 'edicoes.editar', 'edicoes.excluir', 'edicoes.publicar',
            // Submissões
            'submissoes.ver-todas', 'submissoes.atribuir-revisor', 'submissoes.aceitar', 'submissoes.rejeitar',
            // Pareceres
            'pareceres.ver-todos',
            // Usuários
            'usuarios.gerenciar',
            // Temas
            'temas.gerenciar',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Role: Editor
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $editor->syncPermissions([
            'edicoes.criar', 'edicoes.editar', 'edicoes.publicar',
            'submissoes.ver-todas', 'submissoes.atribuir-revisor',
            'submissoes.aceitar', 'submissoes.rejeitar',
            'pareceres.ver-todos',
            'temas.gerenciar',
        ]);

        // Role: Admin (tudo)
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());
    }
}