<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusSubmissaoAutorMail extends Mailable
{
    use Queueable, SerializesModels;
    public $submissao;

    public function __construct($submissao)
    {
        $this->submissao = $submissao;
    }

    public function build()
    {
        return $this->subject('Atualização no Status da sua Submissão - REVICO')
            ->view('emails.status_submissao');
    }
}
