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

    //HAS MANY
    public function capitulos()
    {
        return $this->hasMany(Capitulo::class)->orderBy('ordem');
    }

    // HELPERS
    public function getStatusLabelAttribute()
    {
        return [
            'rascunho' => 'Rascunho',
            'publicado' => 'Publicado',
        ][$this->status] ?? 'Desconhecido';
    }
    
    public function getStatusBadgeHtmlAttribute()
    {
        $badges = [
            'rascunho' => '<span class="badge bg-secondary">Rascunho</span>',
            'publicado' => '<span class="badge bg-success">Publicado</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Desconhecido</span>';
    }
}
?>