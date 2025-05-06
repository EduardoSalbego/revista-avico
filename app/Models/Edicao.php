<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Edicao extends Model{

    protected $table = 'edicoes';
    
    protected $fillable = [
        'titulo',
        'dataEdicao',  
        'numero_edicao',
        'revista_id'
    ];

    public function revista(){
        $this->hasOne(Revista::class, 'id', 'revista_id');
    }
}
?>