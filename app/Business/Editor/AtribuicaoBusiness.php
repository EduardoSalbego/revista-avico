<?php

namespace App\Business\Editor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Repository\AtribuicaoRepository;




class AtribuicaoBusiness
{


    public function __construct()
    {
    }

    private AtribuicaoRepository $repository;


    public function showAvaliadores()
    {
        $this->repository = new AtribuicaoRepository;
        return $this->repository->showAvaliadores();
    }

    public function atribuirAvaliacao(Request $request)
    {

        if ($this->atribuicaoUnica($request->artigo, $request->id)) {
            return redirect()->back()->with('fail_msg', 'O artigo já foi atribuído a este avaliador');
        } elseif (!$this->atribuicaoUnica($request->artigo, $request->id)) {
            Session::flash('message', 'Avaliação atribuída com sucesso.');
            $this->repository = new AtribuicaoRepository;
            return $this->repository->atribuirAvaliacao($request);
        }
    }
    public function atribuicaoUnica($artigo_id, $avaliador_id)
    {
        return DB::table('artigoavaliador')->where('artigo_id', $artigo_id)->where('avaliador_id', $avaliador_id)->exists();
    }
}
