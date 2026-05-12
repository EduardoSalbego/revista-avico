<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PagamentoAprovadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $detalhes;

    public function __construct($user, $detalhes)
    {
        $this->user = $user;
        $this->detalhes = $detalhes;
    }

    public function build()
    {
        return $this->subject('Seu pagamento foi aprovado! Assinatura Ativa 🎉 - REVICO')
            ->view('emails.pagamento_aprovado');
    }
}