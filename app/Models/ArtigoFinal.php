<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtigoFinal extends Model{
        public $table = "artigos";

        protected $fillable = [
            'situacao_id',
            'tituloArtigo',
            'caminhoArtigo',
            'edicao_id'
        ];

        public function autores(){
            return $this->belongsToMany(Autor::class, 'ArtigoAutor', 'artigo_id', 'autor_id');
        }

        public function submissao(){
            return $this->belongsToMany(Submissao::class);
        }

        public function situacao(){
            return $this->hasOne(Situacao::class, 'id', 'situacao_id');
        }

        public function edicao(){
            return $this->hasOne(Edicao::class, 'id', 'edicao_id');
        }
    }

?>
