<?php

namespace App\Repository;

use Illuminate\Http\Request;
use App\Models\Edicao;
use App\Models\ArtigoFinal;
use Illuminate\Support\Facades\DB;


class EdicaoRepository
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $edicao = new Edicao();
            $edicao->revista_id = $request->id;
            $edicao->titulo = $request->titulo;
            $edicao->numero_edicao = (Edicao::where('revista_id', '=', $request->id)->max('numero_edicao')) + 1;
            $edicao->save();

            foreach ($request->artigo as $art) {
                $art = ArtigoFinal::where('id', '=', $art)->first();
                $art->edicao_id = $edicao->id;
                $art->situacao_id = 5; // 5 = publicado
                $art->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return False;
        }
    }
}
?>