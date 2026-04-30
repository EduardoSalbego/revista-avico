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
        'arquivo_pdf_revisado',
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
        return $this->belongsToMany(User::class, 'submissao_revisores_sugeridos', 'submissao_id', 'revisor_id');
    }

    // Revisores atribuídos (pivot)
    public function revisoresAtribuidos()
    {
        return $this->belongsToMany(
            User::class,
            'submissao_revisor',
            'submissao_id',
            'revisor_id'
        )->withPivot('atribuido_em')->withTimestamps();
    }

    public function pareceres()
    {
        return $this->hasMany(Parecer::class);
    }

    public function todosRevisoresResponderam(): bool
    {
        $aceitaram = $this->pareceres()->where('aceito_tarefa', true)->count();
        $responderam = $this->pareceres()
            ->where('aceito_tarefa', true)
            ->whereNotNull('decisao')
            ->count();

        return $aceitaram > 0 && $aceitaram === $responderam;
    }

    // Verifica se algum revisor pediu major_review
    public function temMajorReview(): bool
    {
        return $this->pareceres()->where('decisao', 'major_review')->exists();
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
            'em_revisao' => '<span class="badge bg-info text-dark">Em Revisão</span>',
            'aceito' => '<span class="badge bg-success">Aceito</span>',
            'rejeitado' => '<span class="badge bg-danger">Rejeitado</span>',
            'major_review' => '<span class="badge bg-warning text-dark">Major Review</span>',
            'revisao_pontual' => '<span class="badge bg-info text-dark">Revisão Pontual</span>',
            default => '<span class="badge bg-light text-dark">–</span>',
        };
    }
}
