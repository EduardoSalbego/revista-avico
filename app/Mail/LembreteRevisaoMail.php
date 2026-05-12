<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LembreteRevisaoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $submissao;

    public function __construct($user, $submissao)
    {
        $this->user = $user;
        $this->submissao = $submissao;
    }

    public function build()
    {
        return $this->subject('Lembrete: Revisão de Manuscrito Pendente')
            ->view('emails.lembrete_revisor');
    }
}
