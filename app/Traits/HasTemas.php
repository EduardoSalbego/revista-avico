<?php

namespace App\Traits;

use App\Models\Tema;

trait HasTemas
{
    public function temas()
    {
        return $this->belongsToMany(Tema::class)
            ->withTimestamps();
    }

    public function temaTema(int $temaId): bool
    {
        return $this->temas()->where('tema_id', $temaId)->exists();
    }

    public function sincronizarTemas(array $temaIds): void
    {
        $this->temas()->sync($temaIds);
    }
}
