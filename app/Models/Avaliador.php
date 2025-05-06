<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Avaliador extends Authenticatable
{
    use HasFactory, HasRoles, Authorizable;

    protected $fillable = [
        'area_pref',
        'user_id'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function area()
    {
        return $this->hasOne(Area::class, 'id', 'area_pref');
    }
}
