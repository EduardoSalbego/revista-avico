<div
    style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">

    {{-- Cabeçalho / Logo (Você pode trocar por uma tag <img> com a logo da revista depois) --}}
    <div style="text-align: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
        <h1 style="color: #1a1a2e; margin: 0;">REVICO</h1>
        <p style="color: #777; margin: 5px 0 0 0; font-size: 14px;">Revista Científica Online</p>
    </div>

    <h2 style="color: #0d6efd;">Conta criada com sucesso!</h2>

    <p>Olá, <strong>{{ $user->name }}</strong>,</p>

    <p>Seja muito bem-vindo(a) à nossa plataforma. O seu cadastro foi realizado com sucesso!</p>

    <div style="background-color: #f8f9fa; padding: 15px; border-left: 4px solid #1a1a2e; margin-bottom: 20px;">
        <p style="margin: 0;">A partir de agora, você já pode acessar o sistema para realizar a <strong>submissão de
                novos artigos</strong>, acompanhar o andamento das suas avaliações e interagir com a equipe editorial.
        </p>
    </div>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ route('login') }}"
            style="background-color: #0d6efd; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
            Acessar Minha Conta
        </a>
    </div>

    <p style="font-size: 12px; color: #777;">
        Se você não realizou este cadastro, por favor, ignore este e-mail.
        <br><br>
        Atenciosamente,<br>
        <strong>Equipe Editorial REVICO</strong>
    </p>
</div>
