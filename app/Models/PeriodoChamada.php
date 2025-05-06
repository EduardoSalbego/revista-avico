<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

    class PeriodoChamada extends Model{
        protected $table = 'PeriodoChamada';
        public $timestamps = false;

        protected $fillable = [
            'dataInicio',
            'dataFinal',
            'dataMaximaAvaliacao',
            'dataDivulgacao',
        ];


        public function revista(){
            return $this->belongsTo(Revista::class);
        }
    }
?>