<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Tema extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'slug', 'descricao', 'ativo'];

    protected static function booted(): void
    {
        static::creating(function (Tema $tema) {
            $tema->slug ??= Str::slug($tema->nome);
        });
    }

    public function autores()
    {
        return $this->belongsToMany(Autor::class);
    }

    public function revisores()
    {
        return $this->belongsToMany(Revisor::class);
    }

    public function leitores()
    {
        return $this->belongsToMany(Leitor::class);
    }

    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }
}
