<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NovaSubmissaoAutorMail extends Mailable
{
    use Queueable, SerializesModels;

    public $submissao;

    public function __construct($submissao)
    {
        $this->submissao = $submissao;
    }

    public function build()
    {
        return $this->subject('Confirmação de Submissão de Artigo - REVICO')
            ->view('emails.nova_submissao');
    }
}
