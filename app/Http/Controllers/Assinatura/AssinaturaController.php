<?php

namespace App\Http\Controllers\Assinatura;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\PagamentoAprovadoMail;

class AssinaturaController extends Controller
{
    public function processar(Request $request)
    {
        $request->validate([
            'plano' => 'required|in:Mensal,Semestral,Anual'
        ]);

        $user = Auth::user();

        $meses = 0;
        if ($request->plano == 'Mensal')
            $meses = 1;
        elseif ($request->plano == 'Semestral')
            $meses = 6;
        elseif ($request->plano == 'Anual')
            $meses = 12;

        $dataBase = ($user->assinante_ate && Carbon::parse($user->assinante_ate)->isFuture())
            ? Carbon::parse($user->assinante_ate)
            : now();

        $user->update([
            'assinante_ate' => $dataBase->addMonths($meses)
        ]);
        $detalhes = [
            'plano' => $request->plano,
            'validade' => $user->assinante_ate->format('d/m/Y'),
        ];

        // Dispara o e-mail de pagamento aprovado
        Mail::to($user->email)->send(new PagamentoAprovadoMail($user, $detalhes));

        return redirect()->route('edicoes.index')->with('success', 'Pagamento aprovado! Seu acesso exclusivo foi liberado com sucesso.');
    }
}
