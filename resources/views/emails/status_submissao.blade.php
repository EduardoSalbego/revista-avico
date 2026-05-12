<div
    style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
    <h2 style="color: #1a1a2e;">Atualização de Submissão</h2>

    <p>Olá,</p>

    <p>O status do seu artigo submetido à <strong>REVICO</strong> foi atualizado.</p>

    <div style="background-color: #f8f9fa; padding: 15px; border-left: 4px solid #1a1a2e; margin-bottom: 20px;">
        <p style="margin: 0 0 10px 0;"><strong>Título:</strong> {{ $submissao->titulo }}</p>
        <p style="margin: 0; font-size: 16px;">
            <strong>Novo Status:</strong>
            <span
                style="color: #0d6efd; font-weight: bold;">{{ strtoupper(str_replace('_', ' ', $submissao->status)) }}</span>
        </p>
    </div>

    @if ($submissao->observacoes)
        <p><strong>Feedback Editorial:</strong></p>
        <div
            style="background-color: #fff3cd; color: #856404; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-size: 14px;">
            {{ $submissao->observacoes }}
        </div>
    @endif

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ route('autor.submissoes.index') }}"
            style="background-color: #1a1a2e; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
            Ver Detalhes no Sistema
        </a>
    </div>

    <p style="font-size: 12px; color: #777;">
        Atenciosamente,<br>
        <strong>Equipe Editorial REVICO</strong>
    </p>
</div>
