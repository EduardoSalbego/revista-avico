<?php 
namespace App\Repository;

use App\Models\ArtigoFinal;

class ArtigoRepository{
   
    public function getSubmissaoByID($id){
        return ArtigoFinal::where('id', $id);
    }

}

?>