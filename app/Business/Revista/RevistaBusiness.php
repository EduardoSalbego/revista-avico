<?php

namespace App\Business\Revista;

use App\Models\PeriodoChamada;
use App\Models\Revista;
use App\Repository\RevistaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevistaBusiness{

    private RevistaRepository $repository;

    public function __construct() { }

    public function createRevista(Request $request){
        $periodos_de_chamada = array();
        $periodos_de_chamada = $this->createArrayPeriodoChamada($request);
        $validaPeriodos = $this->validaPeriodoChamado($periodos_de_chamada);

        if($validaPeriodos <> ""){
            return $validaPeriodos;
        }else{
            if(!$this->uniqueISSN($request->issn) && !$this->uniqueTitle($request->titulo)){
                $this->repository = new RevistaRepository;
                $saved = $this->repository->create($request, $periodos_de_chamada);

                return $saved;

            }else{
                return 'False';
            }
        }

    }

    public function createArrayPeriodoChamada(Request $request){
        $periodos_de_chamadas = array();
        $qtd_chamados = sizeof($request->dataInicio);

        for($i = 0; $i < $qtd_chamados; $i++){
            $periodo_chamada = new PeriodoChamada();
            $periodo_chamada->dataInicio = $request->dataInicio[$i];
            $periodo_chamada->dataFinal = $request->dataFinal[$i];
            $periodo_chamada->dataMaximaAvaliacao = $request->dataMaximaAvaliacao[$i];
            $periodo_chamada->dataDivulgacao = $request->dataDivulgacao[$i];

            array_push($periodos_de_chamadas, $periodo_chamada);
        }

        return $periodos_de_chamadas;
    }

    public function createChamado(Request $request){
        $this->repository = new RevistaRepository;

        $this->repository->createChamado($request);
    }

    public function manageRevistas(){
        //verificar se usuário esta autenticado
        //verificar permissões do usuário

        $this->repository = new RevistaRepository;
        return $this->repository->show();

    }


    public function deleteRevista(Request $request){
        //verificar quantidade de edições antes de deletar

        $this->repository = new RevistaRepository;
        return $this->repository->delete($request->id);

    }

    public function selectRevista(Request $request){

        $this->repository = new RevistaRepository;
        $revista = $this->repository->getByID($request->id);

        return $revista;
    }

    public function updateRevista(Request $request){
        $this->repository = new RevistaRepository;
        return $this->repository->update($request);
    }

    //Mover pra repository?
    //Retorna true se já existir uma revista com o mesmo nome
    public function uniqueTitle(String $titulo){
        return DB::table('revistas')->where('tituloRevista', $titulo)->exists();
    }

    //Mover pra repository?
    //Retorna true se já existir uma revista com o mesmo ISSN
    private function uniqueISSN(String $issn){
        return DB::table('revistas')->where('ISSNRevista', $issn)->exists();
    }


    private function validaPeriodoChamado($periodos_de_chamadas){

        foreach($periodos_de_chamadas as $periodo_chamada){
                if($periodo_chamada->dataFinal <= $periodo_chamada->dataInicio)
                    return "ERRO - Data Final Deve Ser Maior Que a Data Inicial!";

                if($periodo_chamada->dataDivulgacao < $periodo_chamada->dataInicial)
                    return "ERRO - A Data de Divulgação Deve Ser Menor Que a Data Inicial!";

                if($periodo_chamada->dataMaximaAvaliacao < $periodo_chamada->dataFinal || $periodo_chamada->dataMaximaAvaliacao < $periodo_chamada->dataFinal)
                    return "ERRO - A Data Máxima de Avaliação deve ser maior que a data de inicio e maior que a data final!";
        }

        return "";
    }
}

?>
