<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artigo extends Model
{
    use HasFactory;

    protected $table = 'artigos';

    protected $fillable = [
        'edicao_id',
        'autor_id',
        'submissao_id',
        'titulo',
        'resumo',
        'arquivo_pdf',
        'ordem',
        'doi',
        'palavras_chave',
        'referencias',
    ];

    protected $casts = [
        'palavras_chave' => 'array',
        'referencias' => 'array',
    ];

    /**
     * O artigo pertence a uma edição
     */
    public function edicao()
    {
        return $this->belongsTo(Edicao::class, 'edicao_id');
    }

    /**
     * O artigo possui vários autores
     */
    public function autores()
    {
        return $this->hasMany(Autor::class, 'artigo_id');
    }

    public function submissao()
    {
        return $this->belongsTo(Submissao::class);
    }
}