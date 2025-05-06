<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodicidade extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'descricaoPeriodicidade',
    ];


    public function revista(){
        return $this->belongsTo(Revista::class);
    }
}
