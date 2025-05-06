<?php

namespace App\Models;

use ArtigoFinal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;

    public $table = 'avaliacao';

    
    protected $fillable = [
        'artigo_id',
        'avaliador_id',
        'comentarios',
        'nota',
    ];

    public function artigo(){
        $this->belongsTo(ArtigoFinal::class, 'id', 'artigo_id');
    }

}
