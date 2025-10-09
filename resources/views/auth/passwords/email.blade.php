<!DOCTYPE html>
<html lang="pt-br" class="fontawesome-i2svg-active fontawesome-i2svg-complete">

@include('layouts/head')

<body id="page-top">

    @include('layouts/topbar')

    <main id="content" style="margin-bottom: 79px;">
        <section class="page-section container">
            <form action="https://avicobrasil.com.br/forgot-password" method="post">
                <input type="hidden" name="_token" value="1YfeHZwJ87K8cwljkVEbutM8ODkFZBFNInQ4Oi3g">
                <h1 class="text-center">Recuperação de senha</h1>
                <div
                    class="container-fluid d-md-grid gap-md-2 col-md-6 mx-auto bg-light shadow p-3 mb-5 bg-white rounded">
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control mb-3" name="email" id="email" type="email">
                        <div>
                            <div class="mt-1 mb-1">
                                <span class="text-danger">
                                </span>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Enviar email para recuperação de senha</button>
                </div>
            </form>
        </section>
    </main>

    @include('layouts/footer')
</body>

</html>