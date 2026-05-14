<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Edicao extends Model
{

    protected $table = 'edicoes';

    protected $fillable = [
        'titulo',
        'organizador',
        'imagem_capa',
        'resumo',
        'tipo_acesso',
        'permitir_comentarios',
        'status',
        'data_publicacao',
    ];

    protected $casts = [
        'permitir_comentarios' => 'boolean',
    ];

    public function Artigo()
    {
        return $this->hasMany(Artigo::class, 'edicao_id');
    }

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

    public function getTipoAcessoLabelAttribute()
    {
        return [
            'publica' => 'Pública',
            'exclusiva' => 'Exclusiva',
        ][$this->tipo_acesso] ?? 'Pública';
    }

    public function getTipoAcessoBadgeHtmlAttribute()
    {
        $badges = [
            'publica' => '<span class="badge bg-success">Pública</span>',
            'exclusiva' => '<span class="badge bg-warning text-dark">Exclusiva</span>',
        ];

        return $badges[$this->tipo_acesso] ?? '<span class="badge bg-success">Pública</span>';
    }
}
?>
