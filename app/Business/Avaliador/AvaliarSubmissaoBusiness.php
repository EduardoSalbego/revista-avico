<?php

namespace App\Business\Avaliador;

use App\Models\Revista;
use App\Models\Submissao;
use App\Repository\AutorRepository;
use App\Repository\AvaliarSubmissaoRepository;
use ArtigoFinal;
use Illuminate\Http\Request;

class AvaliarSubmissaoBusiness{

    private AvaliarSubmissaoRepository $repository;


    public function seeAllSubmissions(){
            $this->repository = new AvaliarSubmissaoRepository;

            return $this->repository->showSubmissions();
        }

    public function seeAllArticlesPerSubmission($id){
            $this->repository = new AvaliarSubmissaoRepository;

            return $this->repository->showArticlesPerSubmission($id);
        }

    public function loadArticle($id){
            $this->repository = new AvaliarSubmissaoRepository;

            return $this->repository->showArticle($id);
        }

        public function createAvaliacao($avaliador_id, Request $request){
            $this->repository = new AvaliarSubmissaoRepository;

            return $this->repository->store($avaliador_id, $request);

        }

}
