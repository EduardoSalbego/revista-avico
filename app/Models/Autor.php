<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use App\Traits\HasTemas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Autor extends Model
{
    public $table = 'autores';

    use HasFactory, BelongsToUser, HasTemas;

    protected $fillable = [
        'user_id',
        'artigo_id',
        'lattes_url',
        'orcid',
        'instituicao',
    ];

    // Relacionamentos específicos do Autor
    public function submissoes()
    {
        return $this->hasMany(Submissao::class);
    }

    /**
     * O autor pertence a um artigo
     */
    public function artigo()
    {
        return $this->belongsTo(Artigo::class, 'artigo_id');
    }
}