<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submissao extends Model
{
    public $table = 'submissoes';
    
    protected $fillable = [
        'user_id',
        'titulo',
        'resumo',
        'cover_letter',
        'arquivo_pdf',
        'arquivo_docx',
        'status',
        'observacoes',
    ];

    // Autor da submissão
    public function autor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Revisores sugeridos (pivot)
    public function revisoresSugeridos()
    {
        return $this->belongsToMany(User::class, 'submissao_revisor', 'submissao_id', 'revisor_id');
    }

    // Helpers de status
    public function isSubmetido(): bool
    {
        return $this->status === 'submetido';
    }
    public function isEmRevisao(): bool
    {
        return $this->status === 'em_revisao';
    }
    public function isAceito(): bool
    {
        return $this->status === 'aceito';
    }
    public function isRejeitado(): bool
    {
        return $this->status === 'rejeitado';
    }

    // Badge de status para views
    public function badgeStatus(): string
    {
        return match ($this->status) {
            'submetido' => '<span class="badge bg-secondary">Submetido</span>',
            'em_revisao' => '<span class="badge bg-warning text-dark">Em Revisão</span>',
            'aceito' => '<span class="badge bg-success">Aceito</span>',
            'rejeitado' => '<span class="badge bg-danger">Rejeitado</span>',
            default => '<span class="badge bg-light text-dark">–</span>',
        };
    }
}
