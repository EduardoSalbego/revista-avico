<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Revista extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'editor_id',
        'area_id',
        'periodicidade_id',
        'tituloRevista',
        'limiteArtigo',
        'ISSNRevista',
    ];

    public function editor(){
        return $this->hasOne(Editor::class, 'id', 'editor_id');
    }


    public function periodicidade(){
        return $this->hasOne(Periodicidade::class, 'id', 'periodicidade_id');
    }

    public function area(){
        return $this->hasOne(Area::class, 'id', 'area_id');
    }


    public function submissao(){
        return $this->belongsToMany(Submissao::class);
    }

    public function periodo_chamada(){
        return $this->hasMany(PeriodoChamada::class);
    }
}
