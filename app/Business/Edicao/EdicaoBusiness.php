<?php
namespace App\Business\Edicao;

use App\Models\Edicao;
use App\Models\Revista;
use Illuminate\Http\Request;
use App\Repository\EdicaoRepository;
use Illuminate\Support\Facades\Session;


class EdicaoBusiness
{
    private EdicaoRepository $repository;

    public function __construct() {}

    public function createEdicao(Request $request)
    {
        $revista = Revista::where('id', $request->id)->first();
        if($request->artigo){

            if($revista->limiteArtigo >= count($request->artigo)){
                $this->repository = new EdicaoRepository;
                $this->repository->store($request);
                Session::flash('sucess_message', 'Edição criada com sucesso!');
                return redirect()->route('lista.edicoes', $request->id);
            }else{
                return redirect()
                ->back()
                ->with('fail_msg', 'O limite de artigos é '. $revista->limiteArtigo);
            }
        }else{
            return redirect()
            ->back()
            ->with('no_articles_selected', 'É preciso selecionar pelo menos um artigo');
        }
            
        
    }
}
?>