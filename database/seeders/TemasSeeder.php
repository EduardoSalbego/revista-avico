<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TemasSeeder extends Seeder
{
    public function run()
    {
        $temas = [
            [
                'nome' => 'Saúde Mental Pós-Pandemia',
                'descricao' => 'Impactos psicológicos da pandemia de COVID-19 e estratégias de recuperação emocional.'
            ],
            [
                'nome' => 'Vacinação e Imunização Coletiva',
                'descricao' => 'Estudos sobre vacinas, campanhas de imunização e proteção populacional.'
            ],
            [
                'nome' => 'Qualidade do Sono',
                'descricao' => 'Pesquisas relacionadas ao sono, insônia e hábitos saudáveis.'
            ],
            [
                'nome' => 'Alimentação Saudável',
                'descricao' => 'Nutrição, dietas equilibradas e prevenção de doenças.'
            ],
            [
                'nome' => 'Atividade Física e Bem-Estar',
                'descricao' => 'Benefícios do exercício físico para a saúde física e mental.'
            ],
            [
                'nome' => 'Tecnologia na Medicina',
                'descricao' => 'Uso de inteligência artificial, telemedicina e inovação em saúde.'
            ],
            [
                'nome' => 'Doenças Respiratórias',
                'descricao' => 'Pesquisas sobre COVID-19, gripe, asma e outras doenças respiratórias.'
            ],
            [
                'nome' => 'Saúde Infantil',
                'descricao' => 'Cuidados médicos, vacinação e desenvolvimento infantil.'
            ],
            [
                'nome' => 'Envelhecimento Saudável',
                'descricao' => 'Qualidade de vida e cuidados voltados à terceira idade.'
            ],
            [
                'nome' => 'Saúde Pública',
                'descricao' => 'Políticas públicas, prevenção e acesso à saúde.'
            ],
            [
                'nome' => 'Pandemias e Epidemiologia',
                'descricao' => 'Análises de surtos, transmissão de doenças e controle epidemiológico.'
            ],
            [
                'nome' => 'Ansiedade e Estresse',
                'descricao' => 'Fatores emocionais e métodos de tratamento e prevenção.'
            ],
            [
                'nome' => 'Hábitos Saudáveis',
                'descricao' => 'Rotinas e práticas para melhorar a qualidade de vida.'
            ],
            [
                'nome' => 'Saúde no Trabalho',
                'descricao' => 'Bem-estar corporativo, burnout e ergonomia.'
            ],
            [
                'nome' => 'Medicina Preventiva',
                'descricao' => 'Prevenção de doenças e promoção da saúde.'
            ],
            [
                'nome' => 'Impactos Sociais da COVID-19',
                'descricao' => 'Consequências sociais, econômicas e culturais da pandemia.'
            ],
            [
                'nome' => 'Saúde Digital',
                'descricao' => 'Aplicativos, plataformas e recursos digitais voltados ao bem-estar.'
            ],
            [
                'nome' => 'Pesquisa Científica em Saúde',
                'descricao' => 'Novos estudos, descobertas e metodologias científicas.'
            ],
            [
                'nome' => 'Reabilitação Pós-COVID',
                'descricao' => 'Tratamentos e recuperação de pacientes após infecção por COVID-19.'
            ],
            [
                'nome' => 'Bem-Estar e Mindfulness',
                'descricao' => 'Práticas de meditação, atenção plena e equilíbrio emocional.'
            ],
        ];

        foreach ($temas as $tema) {
            DB::table('temas')->insert([
                'nome' => $tema['nome'],
                'slug' => Str::slug($tema['nome']),
                'descricao' => $tema['descricao'],
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $temasAleatorios = collect(range(1, 20))
            ->shuffle()
            ->take(rand(2, 10));
        foreach ($temasAleatorios as $temaId) {
            DB::table('revisor_tema')->insert([
                'revisor_id' => 1,
                'tema_id' => $temaId,
            ]);
            DB::table('revisor_tema')->insert([
                'revisor_id' => 2,
                'tema_id' => $temaId,
            ]);
            DB::table('revisor_tema')->insert([
                'revisor_id' => 3,
                'tema_id' => $temaId,
            ]);
            DB::table('autor_tema')->insert([
                'autor_id' => 1,
                'tema_id' => $temaId,
            ]);
            DB::table('leitor_tema')->insert([
                'leitor_id' => 1,
                'tema_id' => $temaId,
            ]);
        }
    }
}