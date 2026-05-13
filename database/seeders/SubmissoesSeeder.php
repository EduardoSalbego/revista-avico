<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Submissao;
use Illuminate\Support\Facades\DB;

class SubmissoesSeeder extends Seeder
{
    public function run()
    {
        $revisores = [1, 2, 3];

        for ($i = 1; $i <= 5; $i++) {

            $submissao = Submissao::create([
                'user_id' => 6,
                'titulo' => "Cuidados preventivos e comunicacao em saude publica",
                'resumo' => "O artigo discute como estrategias de comunicacao clara, cuidado preventivo e acompanhamento continuo contribuem para a adesao da populacao a praticas de saude mais seguras. O artigo discute como estrategias de comunicacao clara, cuidado preventivo e acompanhamento continuo contribuem para a adesao da populacao a praticas de saude mais seguras.",
                'cover_letter' => "Carta de apresentação do artigo {$i}",
                'arquivo_pdf' => 'storage/artigos/exemplo.pdf',
                'arquivo_docx' => null,
                'status' => 'aceito',
                'deadline' => now()->addDays(60),
            ]);

            DB::table('submissao_autor')->insert([
                'submissao_id' => $submissao->id,
                'nome' => "Paulo Júlio Silva",
                'instituicao' => "UNIPAMPA - Universidade Federal do Pampa",
                'autor_principal' => true,
                'ordem' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('submissao_autor')->insert([
                [
                    'submissao_id' => $submissao->id,
                    'nome' => "Maria Fernanda Oliveira",
                    'instituicao' => "UFRJ - Universidade Federal do Rio de Janeiro",
                    'autor_principal' => false,
                    'ordem' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'submissao_id' => $submissao->id,
                    'nome' => "Cláudia Pereira Santos",
                    'instituicao' => "USP - Universidade de São Paulo",
                    'autor_principal' => false,
                    'ordem' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);

            foreach ($revisores as $index => $revisorId) {

                // atribuição (pivot)
                DB::table('submissao_revisor')->insert([
                    'submissao_id' => $submissao->id,
                    'revisor_id' => $revisorId,
                    'atribuido_em' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // alterna decisão
                $decisao = $index % 2 == 0 ? 'aceito' : 'rejeitado';

                // parecer
                DB::table('pareceres')->insert([
                    'submissao_id' => $submissao->id,
                    'revisor_id' => $revisorId,
                    'aceito_tarefa' => 1,
                    'decisao' => $decisao,
                    'comentario' => "Parecer do revisor {$revisorId} para o artigo {$i}. Decisão: {$decisao}.",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}