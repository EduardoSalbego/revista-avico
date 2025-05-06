<?php 
namespace App\Repository;

use App\Models\ArtigoFinal;
use App\Models\Autor;
use App\Models\Revista;
use App\Models\Submissao;
use App\Models\SubmissaoArtigo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubmissaoRepository{
   
    public function create(Request $request, $caminhoArtigos, $autor){
        DB::beginTransaction();
        try{
            $submissao = new Submissao();
            Revista::findOrFail($request->revista_id);
            $submissao->revista_id = $request->revista_id;
            $submissao->autor_id = $autor->orcid;
            $submissao->periodo_id = $request->periodo_id;
            $submissao->finalizado = False;
            $submissao->save();
            
            $i = 0;
            foreach($request->artigo as $art){
                $artigo    = new ArtigoFinal();
                $artigo->tituloArtigo = $request->tituloArtigo[$i];
                $artigo->caminhoArtigo = $caminhoArtigos[$i];   
                $artigo->situacao_id = 4; //Sem Avaliadores Definidos
                $artigo->save();
                $autores = $request->autor_id ;

                foreach($autores as $id){
                    $artigo->autores()->attach($id);
                }
                $submissao->artigos()->attach($artigo->getKey());
                $i = $i + 1;
            }
            DB::commit();
            return True;

        }catch(\Exception $e){
            DB::rollBack();
            return False;
        }

        
    }

    public function showMySubmissions($autor){
        return Submissao::where('autor_id', $autor)->paginate(10);
    }

    public function getArtigosBySubmissionID($submissao_id){
        try{   
            $artigos_submissao = SubmissaoArtigo::where('submissao_id', $submissao_id)->get()->toArray();   
            $artigos = array();
            foreach($artigos_submissao as $artigo){
               array_push($artigos, ArtigoFinal::findOrFail($artigo['artigo_id']));
            }
            return $artigos;
        }catch(\Exception $e){
            echo 'Ocorreu um erro ' . $e;
        }
    }

    public function delete($id){
        
        try{
            $submissao = Submissao::findOrFail($id);
            $submissao->artigos()->delete($submissao);
            $submissao->delete();
        }catch(\Exception $e){
            return False;
        }

        return True;
    }

}

?>