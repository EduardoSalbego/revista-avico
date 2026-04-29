<?php

namespace Database\Seeders;

use App\Models\Capitulo;
use App\Models\Submissao;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Edicao;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Eduardo Admin',
            'email' => 'admin@revico.com',
            'password' => bcrypt('senha123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Eduardo Revisor',
            'email' => 'revisor@revico.com',
            'password' => bcrypt('senha123'),
            'role' => 'revisor',
        ]);

        User::create([
            'name' => 'Eduardo Revisor 2',
            'email' => 'revisor2@revico.com',
            'password' => bcrypt('senha123'),
            'role' => 'revisor',
        ]);

        User::create([
            'name' => 'Eduardo Revisor 3',
            'email' => 'revisor3@revico.com',
            'password' => bcrypt('senha123'),
            'role' => 'revisor',
        ]);

        Submissao::create([
            'user_id' => 1,
            'titulo' => 'Saúde em Tempos de COVID-19',
            'resumo' => 'Reflexões sobre os desafios e aprendizados relacionados à saúde durante a pandemia de COVID-19.',
            'cover_letter' => 'Prezados editores, submeto para avaliação o artigo "Saúde em Tempos de COVID-19", que aborda os impactos da pandemia na saúde pública e mental. Acredito que este tema é de grande relevância para os leitores da revista e pode contribuir para a discussão sobre cuidados e prevenção. Agradeço pela consideração.',
            'arquivo_pdf' => 'storage/artigos/0326182021121461b80edad0f7f.pdf',
            'arquivo_docx' => null,
            'status' => 'em_revisao',
        ]);

        DB::table('submissao_revisor')->insert([
            'submissao_id' => 1,
            'revisor_id' => 1,
            'atribuido_em' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pareceres')->insert([
            'submissao_id' => 1,
            'revisor_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Edicao::create([
            'titulo' => 'Edição 1',
            'autor' => 'Eduardo Salbego',
            'imagem_capa' => 'capas/1777319486_Mínimo Montanhas Viagem Revista.jpg',
            'status' => 'publicado',
        ]);

        Capitulo::create([
            'edicao_id' => 1,
            'titulo' => 'Capítulo 1',
            'ordem' => 1,
            'conteudo_html' => '<h2>Edi&ccedil;&atilde;o Especial: Sa&uacute;de em Tempos de COVID-19</h2>
<h3>Cuidar de si nunca foi t&atilde;o essencial</h3>
<p>A pandemia de COVID-19 transformou profundamente a maneira como lidamos com a sa&uacute;de, o trabalho e as rela&ccedil;&otilde;es humanas. Mais do que uma crise sanit&aacute;ria, esse per&iacute;odo evidenciou a import&acirc;ncia de h&aacute;bitos saud&aacute;veis, do cuidado emocional e do acesso &agrave; informa&ccedil;&atilde;o confi&aacute;vel. Nesta edi&ccedil;&atilde;o, reunimos reflex&otilde;es e orienta&ccedil;&otilde;es para atravessar esse cen&aacute;rio com mais consci&ecirc;ncia e equil&iacute;brio.</p>
<h3>Entendendo a COVID-19 hoje</h3>
<p>Desde os primeiros casos registrados, muita coisa mudou. O avan&ccedil;o das vacinas, a adapta&ccedil;&atilde;o dos sistemas de sa&uacute;de e o maior conhecimento sobre o v&iacute;rus trouxeram mais seguran&ccedil;a para a popula&ccedil;&atilde;o. Ainda assim, a COVID-19 continua sendo uma doen&ccedil;a relevante, especialmente para grupos de risco, como idosos e pessoas com comorbidades.</p>
<p>Mesmo em um cen&aacute;rio mais controlado, medidas simples como higienizar as m&atilde;os, manter ambientes ventilados e respeitar o isolamento em caso de sintomas continuam sendo fundamentais para evitar a propaga&ccedil;&atilde;o.</p>
<h3>Sa&uacute;de mental: o impacto silencioso da pandemia</h3>
<p>Se por um lado o v&iacute;rus afetou o corpo, por outro, a pandemia deixou marcas profundas na sa&uacute;de mental. Ansiedade, estresse e sensa&ccedil;&atilde;o de isolamento tornaram-se comuns durante per&iacute;odos de distanciamento social.</p>
<p>Cuidar da mente &eacute; t&atilde;o importante quanto cuidar do corpo. Manter uma rotina equilibrada, buscar momentos de lazer e, quando necess&aacute;rio, procurar ajuda profissional s&atilde;o atitudes essenciais para preservar o bem-estar emocional.</p>
<h3>A import&acirc;ncia da vacina&ccedil;&atilde;o</h3>
<p>A vacina&ccedil;&atilde;o foi um dos maiores marcos no combate &agrave; COVID-19. Ela n&atilde;o apenas reduz a gravidade da doen&ccedil;a, como tamb&eacute;m contribui para a prote&ccedil;&atilde;o coletiva.</p>
<p>Manter o calend&aacute;rio vacinal atualizado &eacute; uma forma de cuidado individual e tamb&eacute;m um ato de responsabilidade social. Quanto maior a cobertura vacinal, menores s&atilde;o as chances de surgirem novas variantes preocupantes.</p>
<h3>H&aacute;bitos saud&aacute;veis para fortalecer a imunidade</h3>
<p>Durante a pandemia, ficou ainda mais evidente o papel do estilo de vida na sa&uacute;de. Alimenta&ccedil;&atilde;o equilibrada, pr&aacute;tica regular de exerc&iacute;cios f&iacute;sicos e boas noites de sono s&atilde;o pilares que ajudam o organismo a se manter forte.</p>
<p>Al&eacute;m disso, reduzir o consumo de &aacute;lcool, evitar o tabagismo e manter-se hidratado s&atilde;o atitudes que fazem diferen&ccedil;a tanto na preven&ccedil;&atilde;o quanto na recupera&ccedil;&atilde;o de doen&ccedil;as.</p>
<h3>O futuro da sa&uacute;de p&oacute;s-pandemia</h3>
<p>A pandemia acelerou mudan&ccedil;as importantes, como o uso da telemedicina e a valoriza&ccedil;&atilde;o da ci&ecirc;ncia. O aprendizado adquirido nesse per&iacute;odo pode contribuir para um sistema de sa&uacute;de mais preparado e acess&iacute;vel.</p>
<p>O desafio agora &eacute; transformar as li&ccedil;&otilde;es vividas em a&ccedil;&otilde;es permanentes, promovendo uma cultura de preven&ccedil;&atilde;o e cuidado cont&iacute;nuo com a sa&uacute;de.</p>
<h3>Conclus&atilde;o: um novo olhar para o cuidado</h3>
<p>A COVID-19 deixou um legado que vai al&eacute;m da doen&ccedil;a. Ela nos ensinou sobre responsabilidade coletiva, a import&acirc;ncia da informa&ccedil;&atilde;o e o valor de cuidar de si e dos outros.</p>
<p>Mais do que nunca, sa&uacute;de &eacute; um conceito amplo &mdash; que envolve corpo, mente e sociedade. E esse cuidado come&ccedil;a nas pequenas atitudes do dia a dia.</p>',
        ]);


    }
}