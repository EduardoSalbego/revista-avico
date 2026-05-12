<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // -------------------------------------------------------
    // Relacionamentos com perfis (1:1 por design)
    // -------------------------------------------------------

    public function autor(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Autor::class);
    }

    public function revisor(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Revisor::class);
    }

    public function leitor(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Leitor::class);
    }

    // -------------------------------------------------------
    // Helpers de verificação de perfil
    // -------------------------------------------------------

    public function isAutor(): bool
    {
        return $this->autor()->exists();
    }

    public function isRevisor(): bool
    {
        return $this->revisor()->exists();
    }

    public function isLeitor(): bool
    {
        return $this->leitor()->exists();
    }
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }
    public function isEditor(): bool
    {
        return $this->hasRole('editor');
    }

    public function revisorAprovado(): bool
    {
        return $this->revisor
            && $this->revisor->status === 'ativo';
    }

    /**
     * Retorna Label das roles do usuáro e seus perfis de domínio (autor, revisor, leitor).
     */
    public function getFuncoesAttribute(): array
    {
        $funcoes = [];

        // Roles
        if ($this->isAdmin()) {
            $funcoes[] = [
                'nome' => 'Admin',
                'classe' => 'bg-danger',
                'icone' => 'fas fa-shield-alt',
            ];
        }

        if ($this->isEditor()) {
            $funcoes[] = [
                'nome' => 'Editor',
                'classe' => 'bg-warning text-dark',
                'icone' => 'fas fa-user-edit',
            ];
        }

        // Perfis
        if ($this->isAutor()) {
            $funcoes[] = [
                'nome' => 'Autor',
                'classe' => 'bg-light text-dark',
                'icone' => 'fas fa-pen',
            ];
        }

        if ($this->isRevisor()) {
            $funcoes[] = [
                'nome' => 'Revisor',
                'classe' => 'bg-info text-dark',
                'icone' => 'fas fa-search',
            ];
        }

        if ($this->isLeitor()) {
            $funcoes[] = [
                'nome' => 'Leitor',
                'classe' => 'bg-secondary',
                'icone' => 'fas fa-book-reader',
            ];
        }

        return $funcoes;
    }

    /**
     * Um usuário pode ter múltiplos perfis.
     */
    public function perfis(): array
    {
        return array_filter([
            'autor' => $this->isAutor(),
            'revisor' => $this->isRevisor(),
            'leitor' => $this->isLeitor(),
        ]);
    }

}