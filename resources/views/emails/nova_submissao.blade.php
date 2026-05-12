<div
    style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">

    {{-- Cabeçalho --}}
    <div style="text-align: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
        <h1 style="color: #1a1a2e; margin: 0;">REVICO</h1>
        <p style="color: #777; margin: 5px 0 0 0; font-size: 14px;">Revista Científica Online</p>
    </div>

    <h2 style="color: #0d6efd;">Submissão Recebida com Sucesso!</h2>

    <p>Olá, <strong>{{ $submissao->autor->user->name ?? 'Autor' }}</strong>,</p>

    <p>Confirmamos o recebimento do seu manuscrito. Agradecemos por escolher a REVICO para a publicação do seu trabalho.
    </p>

    {{-- Resumo da Submissão --}}
    <div style="background-color: #f8f9fa; padding: 15px; border-left: 4px solid #0d6efd; margin-bottom: 20px;">
        <p style="margin: 0 0 8px 0; font-size: 14px;">
            <strong>Título:</strong> {{ $submissao->titulo }}
        </p>
        <p style="margin: 0; font-size: 14px;">
            <strong>Data de Envio:</strong> {{ $submissao->created_at->format('d/m/Y \à\s H:i') }}
        </p>
    </div>

    <h4 style="color: #1a1a2e; margin-bottom: 10px;">Próximos Passos</h4>
    <p style="margin-top: 0;">
        Seu artigo passará agora pela nossa <strong>Triagem Editorial</strong>. Caso aprovado nesta fase inicial, ele
        será encaminhado para a avaliação por pares (<em>peer review</em>). Você será notificado(a) por e-mail sempre
        que houver uma atualização no status do seu trabalho.
    </p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ route('autor.submissoes.index') }}"
            style="background-color: #1a1a2e; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
            Acompanhar Submissão
        </a>
    </div>

    <p style="font-size: 12px; color: #777;">
        Atenciosamente,<br>
        <strong>Equipe Editorial REVICO</strong>
    </p>
</div>
