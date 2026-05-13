<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissaoAutor extends Model
{
    protected $table = "submissao_autor";

    protected $fillable = [
        'submissao_id',
        'nome',
        'instituicao',
        'autor_principal',
        'ordem',
    ];
}
