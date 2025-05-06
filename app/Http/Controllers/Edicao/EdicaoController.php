<?php

namespace App\Http\Controllers\Edicao;

use App\Models\Edicao;
use App\Models\Revista;
use App\Models\Submissao;
use App\Models\ArtigoFinal;
use App\Models\ArtigoAvaliador;
use App\Models\SubmissaoArtigo;
use App\Models\Avaliacao;


use App\Http\Controllers\Controller;


class EdicaoController extends Controller
{
    public function create($id)
    {
        $revista = Revista::where('id', $id)->first();
        $submissoesartigo = SubmissaoArtigo::all();
        $submissoes = Submissao::where('revista_id', $id)->get();
        $artigos = ArtigoFinal::where('situacao_id', '=', 3)->get();

        $arr = array();
        $notas = array();
        foreach ($submissoes as $submissao) {
            $id_da_submissao_certa = $submissao->id;
            foreach ($submissoesartigo as $submissaoartigo) {
                if ($submissaoartigo->submissao_id == $id_da_submissao_certa) {
                    $id_do_artigo_certo = $submissaoartigo->artigo_id;
                    foreach ($artigos as $artigo) {
                        if ($artigo->id == $id_do_artigo_certo) {
                            $numAvaliadores = ArtigoAvaliador::where('artigo_id', $artigo->id)->count('avaliador_id');
                            $sum = Avaliacao::where('artigo_id', $id_do_artigo_certo)->sum('nota');
                            $media = $sum / $numAvaliadores;
                            if($numAvaliadores >= 2){
                                array_push($arr, $artigo);
                                array_push($notas, $media);
                            }
                        }
                    }
                }
            }
        }

        // mandar array pra view
        return view('edicao.create', compact('arr', 'revista', 'submissoes', 'notas'));
    }


    public function manage($id)
    {
        $revista = Revista::where('id', $id)->first();
        $edicoes = Edicao::paginate(10);

        return view('edicao.manage', compact('edicoes', 'revista'));
    }
}
