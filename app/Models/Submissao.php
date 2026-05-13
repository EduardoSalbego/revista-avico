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
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    /**
     * Relacionamento que retorna o usuário dono da submissão
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento que retorna o autor principal.
     */
    public function autor()
    {
        return $this->hasOne(SubmissaoAutor::class)
            ->where('autor_principal', true);
    }

    /**
     * Relacionamento para buscar todos os autores (caso precise listar em alguma view).
     */
    public function autores()
    {
        return $this->hasMany(SubmissaoAutor::class)
            ->orderBy('ordem');
    }

    // Revisores sugeridos (pivot)
    public function revisoresSugeridos()
    {
        return $this->hasMany(SubmissaoRevisorSugerido::class);
    }

    // Revisores atribuídos (pivot)
    public function revisoresAtribuidos()
    {
        return $this->belongsToMany(
            Revisor::class,
            'submissao_revisor',
            'submissao_id',
            'revisor_id'
        )->withPivot('atribuido_em', 'status', 'ultima_notificacao_em')->withTimestamps();
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

    public function artigoEnviado(): bool
    {
        return Artigo::where('titulo', $this->titulo)->exists();
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
    public function isMajorReview(): bool
    {
        return $this->status === 'major_review';
    }
    public function isRevisaoPontual(): bool
    {
        return $this->status === 'revisao_pontual';
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
