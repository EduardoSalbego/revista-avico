<?php

namespace App\Service;

use App\Repository\RevistaRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RevistaService{

    private RevistaRepository $repository;
    
    public function search(Request $request){
        $q = $request->query('q');
        
        echo  $this->queryTitle($q);
    }

    public function queryTitle($title){
        
        if(strlen($title) > 0 ){
            $this->repository = new RevistaRepository;        
            
            $revistas = $this->repository->queryTitle($title);
            $response_html = '';
            $disabilitado = "color: #FFFF; pointer-events: none; display: inline-block;";
            $now = Carbon::now()->format('Y-m-d');
            foreach($revistas as $revista){
                foreach($revista->periodo_chamada as $chamado){
                if(($chamado->dataInicio >= $now && $chamado->dataFinal >= $now) && $chamado->dataDivulgacao >= $now)
                    $disabilitado = "";
                    
                }

                if($disabilitado == "")
                    $response_html = $response_html . '<a type="button" style="'. $disabilitado .'" onclick="select('.$revista->id.','.$revista->limiteArtigo.')" ><li class="list-group-item" id='.$revista->id.'>'.$revista->tituloRevista.'</li></a>';

                    
                $disabilitado = "";
            }

            return $response_html;
        }

    }

}

?>