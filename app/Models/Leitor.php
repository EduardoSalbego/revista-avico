<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use App\Traits\HasTemas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leitor extends Model
{
    public $table = 'leitores';
    
    use HasFactory, BelongsToUser, HasTemas;

    protected $fillable = [
        'user_id',
    ];
}
