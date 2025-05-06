<?php

namespace App\Business\Submissao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repository\AutorRepository;
use App\Repository\SubmissaoRepository;
use Illuminate\Support\Facades\Storage;


class SubmissaoBusiness{

    private SubmissaoRepository $repository;
    const LIMITE = 52428800; // quantidade de bytes equivantes a 50MB
    const FORMATOS_ACEITOS = ['pdf']; //Novos formatos adicionar aqui


    public function validateFile($file){
        if($file->isValid() && $file->getSize() < self::LIMITE){
            $extension = $file->getClientOriginalExtension();
            foreach(self::FORMATOS_ACEITOS as $format){
                if($format == $extension)
                    return True;
            }
        }
        return False;
    }

    public function createSubmissao(Request $request){

        $caminhosArtigos = [];
        foreach($request->artigo as $artigo){
            $name = uniqid(date('HisYmd'));
            $extension = $artigo->extension();
            $path = Storage::disk('s3')->put("artigos", $artigo, "application/pdf");
            $path = Storage::url($path);
            $caminhosArtigos[] = $path;
        }

        $this->repository = new SubmissaoRepository();
        $current_user_id = auth()->user()->id;
        $autor_repository = new AutorRepository();
        $autor = $autor_repository->getAutorByUserID($current_user_id);

        $i=0;
        foreach($request->artigo as $art){
            if(!$this->uniqueArticleTitle($request->tituloArtigo[$i])){
                $this->repository->create($request, $caminhosArtigos, $autor);
            }else{
                return 'False';
            }
            $i++;
        }

    }

    public function manageSubmissao(){

        $current_user_id = auth()->user()->id;

        $autor_repository = new AutorRepository();
        $autor = $autor_repository->getAutorByUserID($current_user_id);

        $submissao_repository = new SubmissaoRepository();
        $submissao = $submissao_repository->showMySubmissions($autor->orcid);

        return $submissao;
    }

    public function deleteSubmissao($id){

        $submissao_repository = new SubmissaoRepository();
        $submissao = $submissao_repository->delete($id);

    }

    public function validateStatus($id){
        $this->repository = new SubmissaoRepository();
        $artigos = $this->repository->getArtigosBySubmissionID($id);
        foreach($artigos as $artigo){
            if($artigo->situacao_id != 4)
                return False;
        }
        return True;
    }

    public function uniqueArticleTitle(String $title){
        return DB::table('artigos')->where('tituloArtigo', $title)->exists();
    }
}

?>
