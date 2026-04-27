<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Capitulo extends Model
{

    protected $table = 'capitulos';

    protected $fillable = [
        'edicao_id',
        'titulo',
        'ordem',
        'conteudo_html',
    ];

    public function edicao()
    {
        return $this->belongsTo(Edicao::class);
    }
}
?>