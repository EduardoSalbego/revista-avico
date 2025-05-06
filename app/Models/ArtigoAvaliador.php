<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtigoAvaliador extends Model
{
    use HasFactory;

    public $timestamps = False;
    public $table = 'artigoavaliador';

    protected $fillable = [
        'avaliador_id',
        'artigo_id',
    ];
}
