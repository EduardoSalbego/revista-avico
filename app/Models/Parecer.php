<?php

// ============================================================
// app/Models/Parecer.php
// ============================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parecer extends Model
{
    protected $table = "pareceres";
    protected $fillable = [
        'submissao_id',
        'revisor_id',
        'aceito_tarefa',
        'decisao',
        'comentario',
    ];

    protected $casts = [
        'aceito_tarefa' => 'boolean',
    ];

    public function submissao()
    {
        return $this->belongsTo(Submissao::class);
    }

    public function revisor()
    {
        return $this->belongsTo(Revisor::class, 'revisor_id');
    }

    public function badgeDecisao(): string
    {
        return match ($this->decisao) {
            'aceito' => '<span class="badge bg-success">Aceito</span>',
            'rejeitado' => '<span class="badge bg-danger">Rejeitado</span>',
            'major_review' => '<span class="badge bg-warning text-dark">Major Review</span>',
            'revisao_pontual' => '<span class="badge bg-info text-dark">Revisão Pontual</span>',
            default => '<span class="badge bg-secondary">Pendente</span>',
        };
    }
}