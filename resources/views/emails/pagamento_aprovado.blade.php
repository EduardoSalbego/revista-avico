<div
    style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">

    {{-- Cabeçalho --}}
    <div style="text-align: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
        <h1 style="color: #1a1a2e; margin: 0;">REVICO</h1>
        <p style="color: #777; margin: 5px 0 0 0; font-size: 14px;">Revista Científica Online</p>
    </div>

    <h2 style="color: #198754;">Pagamento Aprovado!</h2>

    <p>Olá, <strong>{{ $user->name }}</strong>,</p>

    <p>Temos uma ótima notícia: o seu pagamento foi processado com sucesso e a sua assinatura já está ativa na nossa
        plataforma.</p>

    {{-- Resumo da Compra --}}
    <div style="background-color: #f8f9fa; padding: 15px; border-left: 4px solid #198754; margin-bottom: 20px;">
        <h4 style="margin-top: 0; margin-bottom: 15px; color: #1a1a2e;">Detalhes da Assinatura</h4>

        <p style="margin: 0 0 8px 0; font-size: 14px;">
            <strong>Plano:</strong> {{ $detalhes['plano'] ?? 'Assinatura REVICO' }}
        </p>
        @if (isset($detalhes['validade']))
            <p style="margin: 0; font-size: 14px;">
                <strong>Próxima renovação / Validade:</strong> {{ $detalhes['validade'] }}
            </p>
        @endif
    </div>

    <p>Você já pode aproveitar todos os recursos exclusivos da sua conta!</p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ route('dashboard') }}"
            style="background-color: #198754; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
            Acessar Minha Assinatura
        </a>
    </div>

    <p style="font-size: 12px; color: #777;">
        Guarde este e-mail como comprovante da sua transação. Se precisar de ajuda entre em contato conosco.
        <br><br>
        Atenciosamente,<br>
        <strong>Equipe REVICO</strong>
    </p>
</div>
