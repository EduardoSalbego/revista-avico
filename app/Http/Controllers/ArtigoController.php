<?php

namespace App\Http\Controllers;

use App\Business\Submissao\SubmissaoBusiness;
use Illuminate\Http\Request;


class ArtigoController extends Controller{

    private SubmissaoBusiness $bussiness;

    public function submitForm(){
        
        return view('artigo.submeter');
    }

    public function delete(Request $request){

        $id = $request->id;
        $this->bussiness = new SubmissaoBusiness;   
        $valido = $this->bussiness->validateStatus($id);
        
        if($valido){
            $this->bussiness->deleteSubmissao($id);
            return redirect()->route('minhas.submissoes');
        }else{
            return redirect()->route('minhas.submissoes')->with('erro004', "Proibido cancelar submissão em avaliação");
        }

    }

    public function submissoes(){
        $this->bussiness = new SubmissaoBusiness;   
        $submissoes = $this->bussiness->manageSubmissao();
        return view('artigo.submissoes', compact('submissoes'));

    }

   public function submit(Request $request){
        $this->bussiness = new SubmissaoBusiness;      
        $valido = True;

        if(!empty($request->autor_id)){
            if($valido){
                $this->bussiness->createSubmissao($request);
                return redirect()->route('minhas.submissoes');   
            }else{
                return redirect()->route('submit.artigo.view')->with('erro001', "Erro ao submeter o artigo!");
            }
        }else
            return redirect()->route('submit.artigo.view')->with('erro002', "Nenhum Autor Informado, selecione pelo menos um autor.");

   }



}

?>