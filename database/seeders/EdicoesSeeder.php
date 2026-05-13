<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Capitulo;
use App\Models\Edicao;

class EdicoesSeeder extends Seeder
{
    public function run()
    {
        Edicao::create([
            'titulo' => 'Edição 1',
            'organizador' => 'Eduardo Salbego',
            'imagem_capa' => 'capas/1777319486_Mínimo Montanhas Viagem Revista.jpg',
            'resumo' => 'A Revista Científica Online REVICO reúne artigos científicos selecionados e publicados em fluxo contínuo, contemplando pesquisas, relatos de experiência e trabalhos acadêmicos desenvolvidos em diferentes áreas do conhecimento. A revista tem como objetivo promover a divulgação científica, incentivar a produção acadêmica e ampliar o acesso ao conhecimento por meio de uma plataforma digital acessível e colaborativa.

Os trabalhos publicados na REVICO passam por um processo de avaliação por pares, garantindo a qualidade, relevância e contribuição científica das produções aprovadas. A revista busca integrar pesquisadores, estudantes, docentes e profissionais, fortalecendo o intercâmbio de ideias e a construção coletiva do conhecimento científico.

Esta edição reúne artigos desenvolvidos por autores de diferentes instituições de ensino e pesquisa, abordando temas contemporâneos e multidisciplinares. Os manuscritos publicados foram submetidos, avaliados e revisados conforme as diretrizes editoriais da revista, incluindo etapas de revisão técnica e científica antes da publicação final.',
            'tipo_acesso' => 'publica',
            'permitir_comentarios' => true,
            'status' => 'publicado',
            'data_publicacao'=> now()->subDays(30),
        ]);

        Edicao::create([
            'titulo' => 'Edição 2',
            'organizador' => 'Eduardo Salbego',
            'imagem_capa' => 'capas/1777319486_Mínimo Montanhas Viagem Revista.jpg',
            'resumo' => 'A Revista Científica Online REVICO reúne artigos científicos selecionados e publicados em fluxo contínuo, contemplando pesquisas, relatos de experiência e trabalhos acadêmicos desenvolvidos em diferentes áreas do conhecimento. A revista tem como objetivo promover a divulgação científica, incentivar a produção acadêmica e ampliar o acesso ao conhecimento por meio de uma plataforma digital acessível e colaborativa.

Os trabalhos publicados na REVICO passam por um processo de avaliação por pares, garantindo a qualidade, relevância e contribuição científica das produções aprovadas. A revista busca integrar pesquisadores, estudantes, docentes e profissionais, fortalecendo o intercâmbio de ideias e a construção coletiva do conhecimento científico.

Esta edição reúne artigos desenvolvidos por autores de diferentes instituições de ensino e pesquisa, abordando temas contemporâneos e multidisciplinares. Os manuscritos publicados foram submetidos, avaliados e revisados conforme as diretrizes editoriais da revista, incluindo etapas de revisão técnica e científica antes da publicação final.',
            'tipo_acesso' => 'exclusiva',
            'permitir_comentarios' => false,
            'status' => 'publicado',
            'data_publicacao' => now(),
        ]);
    }
}
