<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Edicao extends Model
{

    protected $table = 'edicoes';

    protected $fillable = [
        'titulo',
        'autor',
        'imagem_capa',
        'status',
    ];

    public function capitulos()
    {
        return $this->hasMany(Capitulo::class)->orderBy('ordem');
    }
}
?>