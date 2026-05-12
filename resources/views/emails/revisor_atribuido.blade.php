<div
    style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
    <h2 style="color: #0d6efd;">Convite de Revisão</h2>
    <p>Olá, <strong>{{ $user->name }}</strong>,</p>
    <p>Você foi convidado(a) pela equipe editorial da <strong>REVICO</strong> para atuar como avaliador(a) do seguinte
        artigo:</p>
    <div style="background-color: #f8f9fa; padding: 15px; border-left: 4px solid #0d6efd; margin-bottom: 20px;">
        <h4 style="margin-top: 0; color: #1a1a2e;">{{ $submissao->titulo }}</h4>
        <p style="font-size: 14px; color: #555; margin-bottom: 0;">
            <strong>Resumo:</strong> {{ Str::limit($submissao->resumo, 200) }}
        </p>
    </div>
    <p>Por favor, acesse o painel do sistema para aceitar ou declinar este convite de avaliação. O seu retorno rápido é
        muito importante para os autores.</p>
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ route('revisor.pareceres.index') }}"
            style="background-color: #0d6efd; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
            Acessar Mesa do Revisor
        </a>
    </div>
    <p style="font-size: 12px; color: #777;">
        Se você não puder realizar a revisão, poderá indicar um colega na mesma página.
        <br><br>
        Atenciosamente,<br>
        <strong>Equipe Editorial REVICO</strong>
    </p>
</div>
