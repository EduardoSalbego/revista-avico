<!DOCTYPE html>
<html lang="pt-br">

@include('layouts/head')

<body id="page-top">

    @include('layouts/topbar')

    <main id="content" style="margin-bottom: -90px;">
        <section class="page-section">
            <div class="col-md-4 col-md-offset-4 container">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <h3 class="text-center mb-4">Crie sua conta</h3>

                    <div class="form-group mb-3">
                        <label class="form-label" for="nameInput">Nome completo</label>
                        <input class="form-control" name="name" id="nameInput" type="text" placeholder="Digite seu nome"
                            required autofocus>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="emailInput">Email</label>
                        <input class="form-control" name="email" id="emailInput" type="email"
                            placeholder="Digite seu email" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="passwordInput">Senha</label>
                        <input class="form-control" name="password" id="passwordInput" type="password"
                            placeholder="Crie uma senha" required>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="confirmPasswordInput">Confirmar senha</label>
                        <input class="form-control" name="password_confirmation" id="confirmPasswordInput"
                            type="password" placeholder="Repita sua senha" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary mb-2" type="submit">Cadastrar</button>
                    </div>

                    <div class="text-center">
                        <a href="/entrar" class="btn btn-outline-secondary">Já tem uma conta? Faça login</a>
                    </div>
                </form>
                @if ($errors->any())
                    <div class="alert alert-danger mt-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

        </section>
    </main>

    @include('layouts/footer')
</body>

</html>