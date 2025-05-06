<?php

namespace App\Http\Controllers\Avaliador;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Business\Avaliador\AvaliarSubmissaoBusiness;

class AvaliarSubmissaoController extends Controller
{

    private AvaliarSubmissaoBusiness $bussiness;

    public function submissoes()
    {
        $this->business = new AvaliarSubmissaoBusiness;
        $submissoes = $this->business->seeAllSubmissions();
        return view('avaliador.listar_submissoes', ['submissoes' => $submissoes]);
    }

    public function artigos_submissao(Request $request)
    {
        $id = $request->id;
        $this->business = new AvaliarSubmissaoBusiness;
        $submissoes = $this->business->seeAllArticlesPerSubmission($id);

        return view('avaliador.listarartigossubmissao', ['submissoes' => $submissoes]);
    }

    public function artigo(Request $request)
    {
        $id = $request->id;
        $this->business = new AvaliarSubmissaoBusiness;
        $artigo = $this->business->loadArticle($id);

        return view('avaliador.avaliar_artigo', ['artigo' => $artigo]);
    }

    public function create(Request $request)
    {
        $submissao = DB::table('SubmissaoArtigo')->select('submissao_id')->where('artigo_id', $request->id)->first();
        $revista = DB::table('Submissao')->select('revista_id')->where('id', $submissao->submissao_id)->first();
        $periodo_chamada = DB::table('PeriodoChamada')->where('revista_id', $revista->revista_id)->first();
        $currentDate = Carbon::now();
        $currentDateRep = str_replace("-", "/", $currentDate);
        $date = $periodo_chamada->dataMaximaAvaliacao . ' 00:00:00';
        $datamaximaAvaliacaoRep = str_replace("-", "/", $date);

        $avaliador_id = Auth::id();

        $d1 = Carbon::createFromFormat('Y/m/d H:i:s', $currentDateRep);
        $d2 = Carbon::createFromFormat('Y/m/d H:i:s', $datamaximaAvaliacaoRep);

        if ($d2->gt($d1)) {
            $this->bussiness = new AvaliarSubmissaoBusiness;
            $request = $this->bussiness->createAvaliacao($avaliador_id, $request);
            return redirect()->route('listar_submissoes');
        } else {
            Session::flash('message', 'Não está disponível a avaliação desse artigo, já que sua data de avaliação chegou ao fim.');

            return redirect()->route('avaliar.artigo', $request->id);
        }
    }
}
