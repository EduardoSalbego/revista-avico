<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Edicao extends Model{

    protected $table = 'edicoes';
    
    protected $fillable = [
        'titulo',
        'autor',  
        'imagem_capa',
        'tipo_conteudo',
        'arquivo_pdf',
        'conteudo_blocos'
    ];
}
?>