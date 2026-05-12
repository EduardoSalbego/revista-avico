<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use App\Traits\HasTemas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Revisor extends Model
{
    public $table = 'revisores';
    
    use HasFactory, BelongsToUser, HasTemas;

    protected $fillable = [
        'user_id',
        'status',
        'lattes_url',
        'orcid',
        'titulacao',
        'instituicao',
        'max_pareceres_simultaneos',
    ];

    public function pareceres()
    {
        return $this->hasMany(Parecer::class);
    }
}
