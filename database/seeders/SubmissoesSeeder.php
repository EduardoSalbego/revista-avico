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
                'user_id' => 1,
                'titulo' => "Artigo de Teste {$i}",
                'resumo' => "Resumo do artigo {$i}",
                'cover_letter' => "Carta de apresentação do artigo {$i}",
                'arquivo_pdf' => 'storage/artigos/exemplo.pdf',
                'arquivo_docx' => null,
                'status' => 'em_revisao',
            ]);

            DB::table('submissao_autor')->insert([
                'submissao_id' => $submissao->id,
                'nome' => "Autor Principal do Artigo {$i}",
                'autor_principal' => true,
                'ordem' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('submissao_autor')->insert([
                [
                    'submissao_id' => $submissao->id,
                    'nome' => "Coautor A do Artigo {$i}",
                    'autor_principal' => false,
                    'ordem' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'submissao_id' => $submissao->id,
                    'nome' => "Coautor B do Artigo {$i}",
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