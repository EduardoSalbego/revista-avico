<?php

namespace App\Notifications;

use App\Models\Submissao;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SubmissaoDecidida extends Notification
{
    use Queueable;

    public function __construct(public Submissao $submissao)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $aceito = $this->submissao->isAceito();
        $titulo = $this->submissao->titulo;

        $mail = (new MailMessage)
            ->subject(
                $aceito
                ? "✅ Seu artigo foi aceito — {$titulo}"
                : "❌ Resultado da sua submissão — {$titulo}"
            )
            ->greeting("Olá, {$notifiable->name}!")
            ->line(
                $aceito
                ? "Temos ótimas notícias! Seu artigo **\"{$titulo}\"** foi **aceito** para publicação na REVICO."
                : "Informamos que seu artigo **\"{$titulo}\"** não foi aprovado nesta rodada de avaliações."
            );

        if ($this->submissao->observacoes) {
            $mail->line("**Observação do editor:**")
                ->line($this->submissao->observacoes);
        }

        if ($aceito) {
            $mail->action(
                'Enviar versão final (DOCX)',
                route('autor.submissoes.index')
            )->line('Por favor, acesse a plataforma e envie a versão final do seu artigo em formato DOCX.');
        } else {
            $mail->line('Agradecemos sua submissão e encorajamos você a continuar contribuindo com a revista.');
        }

        return $mail->salutation('Equipe REVICO');
    }
}