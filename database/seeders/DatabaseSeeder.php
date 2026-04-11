<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Edicao;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 Admin
        $admin = new User();
        $admin->name = 'Eduardo Admin';
        $admin->email = 'admin@revistaavico.com';
        $admin->password = bcrypt('senha123');
        $admin->role = 'admin';
        $admin->save();

        // 🔹 Conteúdo JSON (reutilizado)
        $conteudo = '[{"tipo":"imagem","conteudo":"blocos_imagens\/1775830923_teste_covid.png","ordem":1},{"tipo":"subtitulo","conteudo":"Segredo dos \'imunes\': por que alguns n\u00e3o t\u00eam covid mesmo expostos ao v\u00edrus?","ordem":2},{"tipo":"paragrafo","conteudo":"Durante a pandemia, uma das principais quest\u00f5es era por que algumas pessoas escapavam da covid-19, enquanto outras contra\u00edam o v\u00edrus v\u00e1rias vezes.","ordem":3},{"tipo":"paragrafo","conteudo":"Por meio de uma colabora\u00e7\u00e3o entre o University College London, o Wellcome Sanger Institute e o Imperial College London, no Reino Unido, nos propusemos a responder a essa pergunta usando o primeiro \"ensaio de desafio\" controlado para covid-19 no mundo.","ordem":4}]';

        // 🔹 Edição 1
        Edicao::create([
            'titulo' => 'Edição 1 - Especial Covid',
            'autor' => 'Equipe AVICO',
            'imagem_capa' => 'capas/1775830923_1.png',
            'tipo_conteudo' => 'blocos',
            'conteudo_blocos' => $conteudo,
        ]);

        // 🔹 Edição 2
        Edicao::create([
            'titulo' => 'Edição 2 - Ciência e Saúde',
            'autor' => 'Equipe AVICO',
            'imagem_capa' => 'capas/1775831224_2.png',
            'tipo_conteudo' => 'blocos',
            'conteudo_blocos' => $conteudo,
        ]);
    }
}