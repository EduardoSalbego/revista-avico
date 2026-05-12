<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissaoRevisorSugerido extends Model
{
    protected $table = 'submissao_revisores_sugeridos';

    protected $fillable = [
        'submissao_id',
        'revisor_id',
        'nome',
        'email',
    ];

    // RELACIONAMENTOS
    public function submissao()
    {
        return $this->belongsTo(Submissao::class);
    }

    public function revisor()
    {
        return $this->belongsTo(Revisor::class);
    }

    // HELPERS
    public function isExterno(): bool
    {
        return $this->revisor_id === null;
    }

    public function isInterno(): bool
    {
        return $this->revisor_id !== null;
    }
}