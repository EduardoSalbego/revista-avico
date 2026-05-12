<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
        }

        .button {
            background-color: #ffc107;
            color: #000;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Olá, {{ $user->name }}!</h2>
        <p>Gostaríamos de lembrar que você possui uma revisão pendente para o trabalho:</p>
        <p><strong>Título:</strong> {{ $submissao->titulo }}</p>
        <p>Sua contribuição é fundamental para o processo editorial. Se possível, solicitamos que finalize a avaliação o
            quanto antes. O prazo limite é {{ $submissao->deadline->format('d/m/Y') }}.</p>
        <br>
        <a href="{{ url('/login') }}" class="button">Acessar Sistema</a>
        <br><br>
        <p>Atenciosamente,<br>Equipe Editorial.</p>
    </div>
</body>

</html>
