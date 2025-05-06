<?php 
namespace App\Repository;

use App\Models\PeriodoChamada;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PeriodoChamadaRepository {
    
    public function getPeriodoChamadaById($periodo_id){
        return PeriodoChamada::where('revista_id', $periodo_id)->get();
    }
}

?>