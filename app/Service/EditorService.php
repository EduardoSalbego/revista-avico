<?php

namespace App\Service;

use App\Repository\EditorRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;

class EditorService{

    private EditorRepository $editorRep;
    private UserRepository $userRep;
    
    public function search(Request $request){
        $q = $request->query('q');       
        echo  $this->queryTitle($q);
    }

    public function queryTitle($title){
        if(strlen($title) > 0 ){
            $this->userRep = new UserRepository;        
            $this->editorRep = new EditorRepository;
            $users = $this->userRep->queryTitle($title);
            $response_html = '';
            foreach($users as $user){
                $editor = $this->editorRep->getEditorByUserID($user->id);
                $response_html = $response_html . '<a type="button" onclick="selectEditor('.$editor->id.')" ><li class="list-group-item" id='.$editor->id.'>'.$user->name.'</li></a>';
            }
            return $response_html;
        }
    }

}


?>