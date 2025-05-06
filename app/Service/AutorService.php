<?php

namespace App\Service;

use App\Repository\AutorRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;

class AutorService{

    private AutorRepository $autorRep;
    private UserRepository $userRep;
    
    public function search(Request $request){
        $q = $request->query('q');       
        echo  $this->queryTitle($q);
    }

    public function queryTitle($title){
        
        if(strlen($title) > 0 ){
            $this->userRep = new UserRepository;        
            $this->autorRep = new AutorRepository;

            $users = $this->userRep->queryTitle($title);
            $response_html = '';

            
            foreach($users as $user){
                $autor = $this->autorRep->getAutorByUserID($user->id);
                $response_html = $response_html . '<a type="button" onclick="selectAuthor('.$autor->orcid.')" ><li class="list-group-item" id='.$autor->orcid.'>'.$user->name.'</li></a>';
            }

            return $response_html;
        }


    }

}


?>