<?php

namespace Database\Seeders;

use App\Models\Artigo;
use App\Models\Autor;
use App\Models\Edicao;
use App\Models\Submissao;
use Illuminate\Database\Seeder;

class ArtigosSeeder extends Seeder
{
    public function run()
    {
        $edicao = Edicao::where('status', 'publicado')->first() ?? Edicao::first();

        if (!$edicao) {
            return;
        }

        $submissoes = Submissao::orderBy('id')->take(5)->get();

        if ($submissoes->isEmpty()) {
            return;
        }

        $artigos = [
            [
                'titulo' => 'Cuidados preventivos e comunicacao em saude publica',
                'resumo' => 'O artigo discute como estrategias de comunicacao clara, cuidado preventivo e acompanhamento continuo contribuem para a adesao da populacao a praticas de saude mais seguras. O artigo discute como estrategias de comunicacao clara, cuidado preventivo e acompanhamento continuo contribuem para a adesao da populacao a praticas de saude mais seguras.',
                'doi' => '10.0000/revico.v1n1.001',
                'palavras_chave' => ['saude publica', 'prevencao', 'comunicacao', 'cuidado', 'educacao'],
                'referencias' => [
                    'BRASIL. Ministerio da Saude. Guia de vigilancia em saude. Brasilia: Ministerio da Saude, 2024.',
                    'WHO. Risk communication and community engagement readiness and response. Geneva: World Health Organization, 2023.',
                ],
            ],
            [
                'titulo' => 'Saude mental e redes de apoio no periodo pos-pandemia',
                'resumo' => 'A pesquisa apresenta reflexoes sobre os impactos emocionais do isolamento social e destaca o papel das redes de apoio, da rotina e do acesso a atendimento especializado.',
                'doi' => '10.0000/revico.v1n1.002',
                'palavras_chave' => ['saude mental', 'apoio social', 'pandemia', 'bem-estar', 'prevencao'],
                'referencias' => [
                    'OPAS. Politica para melhorar a saude mental. Washington, DC: Organizacao Pan-Americana da Saude, 2023.',
                    'SANTOS, M.; ALMEIDA, R. Redes de apoio e cuidado comunitario. Revista Brasileira de Saude, v. 18, n. 2, p. 45-59, 2024.',
                ],
            ],
            [
                'titulo' => 'Vacinas, confianca e responsabilidade coletiva',
                'resumo' => 'O estudo analisa a importancia da confianca publica nas campanhas de imunizacao e os efeitos da informacao qualificada na tomada de decisao coletiva.',
                'doi' => '10.0000/revico.v1n1.003',
                'palavras_chave' => ['vacinacao', 'imunizacao', 'confianca', 'saude coletiva', 'informacao'],
                'referencias' => [
                    'WHO. Immunization agenda 2030: a global strategy to leave no one behind. Geneva: World Health Organization, 2020.',
                    'LIMA, C.; PEREIRA, A. Confianca publica e campanhas de vacinacao. Ciencia & Saude Coletiva, v. 29, n. 1, p. 12-24, 2024.',
                ],
            ],
            [
                'titulo' => 'Telemedicina e acesso ao cuidado continuo',
                'resumo' => 'O artigo investiga possibilidades e limites da telemedicina na ampliacao do acesso, considerando seguranca, acompanhamento longitudinal e inclusao digital.',
                'doi' => '10.0000/revico.v1n1.004',
                'palavras_chave' => ['telemedicina', 'acesso', 'cuidado continuo', 'inclusao digital', 'saude'],
                'referencias' => [
                    'CFM. Resolucao CFM n. 2.314/2022. Define e regulamenta a telemedicina no Brasil. Brasilia: Conselho Federal de Medicina, 2022.',
                    'MARTINS, J.; COSTA, F. Teleatendimento e continuidade do cuidado. Revista de Gestao em Saude, v. 15, n. 3, p. 90-107, 2024.',
                ],
            ],
            [
                'titulo' => 'Habitos saudaveis como estrategia de promocao da saude',
                'resumo' => 'A discussao aborda alimentacao, atividade fisica, sono e reducao de riscos como elementos integrados de promocao da saude e melhoria da qualidade de vida.',
                'doi' => '10.0000/revico.v1n1.005',
                'palavras_chave' => ['habitos saudaveis', 'qualidade de vida', 'atividade fisica', 'alimentacao', 'promocao da saude'],
                'referencias' => [
                    'BRASIL. Ministerio da Saude. Guia alimentar para a populacao brasileira. 2. ed. Brasilia: Ministerio da Saude, 2014.',
                    'SILVA, P.; ROCHA, T. Promocao da saude e mudanca de habitos. Revista Vida e Saude, v. 11, n. 4, p. 33-48, 2023.',
                ],
            ],
        ];

        foreach ($submissoes as $index => $submissao) {
            $dados = $artigos[$index] ?? $artigos[0];
            $autor = Autor::firstOrCreate(['user_id' => $submissao->user_id]);

            Artigo::updateOrCreate(
                ['submissao_id' => $submissao->id],
                [
                    'edicao_id' => $edicao->id,
                    'autor_id' => $autor->id,
                    'titulo' => $dados['titulo'],
                    'resumo' => $dados['resumo'],
                    'arquivo_pdf' => 'artigos/pdfs/exemplo.pdf',
                    'ordem' => $index + 1,
                    'doi' => $dados['doi'],
                    'palavras_chave' => $dados['palavras_chave'],
                    'referencias' => $dados['referencias'],
                ]
            );

            $submissao->update(['status' => 'aceito']);
        }
    }
}
