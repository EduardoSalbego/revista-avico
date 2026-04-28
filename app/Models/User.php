<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Authorizable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'assinante_ate',
        'status',
    ];

    //HELPERS
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }
    public function isRevisor(): bool
    {
        return $this->role === 'revisor';
    }
    public function isAutor(): bool
    {
        return $this->role === 'autor';
    }
    public function isPendente(): bool
    {
        return $this->status === 'pendente';
    }

    public function getRoleLabelAttribute()
    {
        return [
            'admin' => 'Administrador',
            'editor' => 'Editor',
            'autor' => 'Autor',
            'revisor' => 'Revisor',
        ][$this->role] ?? 'Leitor';
    }

    public function getRoleBadgeHtmlAttribute()
    {
        $badges = [
            'admin' => '<span class="badge bg-danger">Admin</span>',
            'editor' => '<span class="badge bg-primary">Editor</span>',
            'autor' => '<span class="badge bg-success">Autor</span>',
            'revisor' => '<span class="badge bg-info text-dark">Revisor</span>',
        ];

        return $badges[$this->role] ?? '<span class="badge bg-secondary">Leitor</span>';
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Submissões que o usuário fez como autor
    public function submissoes()
    {
        return $this->hasMany(Submissao::class, 'user_id');
    }

    // Submissões em que o usuário foi sugerido como revisor
    public function submissoesComoRevisor()
    {
        return $this->belongsToMany(Submissao::class, 'submissao_revisor', 'revisor_id', 'submissao_id');
    }

}
