<?php

namespace App\Http\Controllers\Utils;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Editor;
use App\Models\Revista;

class PopulateTables extends Controller{

    function index(){
        // $this->editores();
        // $this->revistas();
        // $this->areas();
    }


    function editores(){
        Editor::factory()->count(100)->create();
    }

    function revistas(){
        Revista::factory()->count(100)->create();
    }

    function areas(){
        Area::factory()->count(100)->create();
    }

}


?>