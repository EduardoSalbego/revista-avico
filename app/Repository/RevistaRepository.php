<?php

namespace App\Repository;

use App\Models\PeriodoChamada;
use App\Models\Revista;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RevistaRepository
{

    public function create(Request $request, $periodos_de_chamada)
    {
        try {

            $revista = new Revista();
            $revista->editor_id        = $request->editor_id;
            $revista->area_id          = $request->areas;
            $revista->tituloRevista    = $request->titulo;
            $revista->limiteArtigo     = $request->limite;
            $revista->ISSNRevista      = $request->issn;
            $revista->periodicidade_id = $request->periodicidade;

            $revista->save();
            $revista->periodo_chamada()->saveMany($periodos_de_chamada);

            DB::commit();
            return True;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e;
        }
    }

    public function createChamado(Request $request)
    {
        try {

            $periodoChamada = new PeriodoChamada();
            $periodoChamada->revista_id = $request->id;
            $periodoChamada->dataInicio        = $request->datainicio;
            $periodoChamada->dataFinal          = $request->datafinal;
            $periodoChamada->dataMaximaAvaliacao    = $request->dataavaliacao;
            $periodoChamada->dataDivulgacao     = $request->datadivulgacao;

            $periodoChamada->save();

            DB::commit();
            return True;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e;
        }
    }

    public function show()
    {
        return Revista::paginate(10);
    }

    public function queryTitle(String $title)
    {

        //    $revistas = Revista::where('tituloRevista', 'LIKE', '%'.$title.'%')->with(['periodo_chamada' => function ($query) {
        //         $now = Carbon::now()->format('Y-m-d');
        //         $query->where('dataInicio', '>=', $now)
        //                 ->where('dataFinal', '>=', $now)
        //                     ->where('dataDivulgacao', '>=', $now);
        //    }])->get();


        $revistas = Revista::where('tituloRevista', 'LIKE', '%' . $title . '%')->get();

        return $revistas;
    }

    public function getByID($id)
    {

        try {
            $revista = Revista::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return False;
        }

        return $revista;
    }

    public function update(Request $request)
    {
        $revista = $this->getByID($request->id);

        if (!empty($revista) && $revista != False) {
            $revista->update([
                'editor_id' => $request->editor_id,
                'area_id' => $request->areas,
                'tituloRevista' => $request->titulo,
                'limiteArtigo' => $request->limite,
                'ISSNRevista' => $request->issn,
                'periodicidade' => $request->periodicidade,
            ]);
        }
    }

    public function delete($id)
    {

        try {
            $revista = Revista::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return False;
        }

        return $revista->delete();
    }
}
