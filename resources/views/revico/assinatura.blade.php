<!DOCTYPE html>
<html lang="pt-br">

@include('layouts/head')

<body id="page-top">

    @include('layouts/topbar')

    <main id="content" style="margin-bottom: 113px;">
        <section class="page-section">
            <div class="container mt-5 pt-5">

                @if(session('warning'))
                    <div class="alert alert-warning text-center mx-auto mb-4 shadow-sm border-0"
                        style="max-width: 600px; border-radius: 8px;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ session('warning') }}
                    </div>
                @endif

                <div class="text-center mb-4" style="margin-top: {{ session('warning') ? '0' : '-60px' }};">
                    <h2>Assine a</h2>
                    <img src="{{ asset('storage/imagens/revico_texto.png') }}" alt="Logo REVICO"
                        style="height: 40px; margin-bottom: 20px;">
                </div>
                <p class="text-center text-muted mb-5">Escolha o melhor plano para você e tenha acesso a todas
                    as edições exclusivas da revista!</p>

                @php
                    $user = Auth::user();
                    $dataBase = ($user && $user->assinante_ate && \Carbon\Carbon::parse($user->assinante_ate)->isFuture())
                        ? \Carbon\Carbon::parse($user->assinante_ate)
                        : now();
                    // Somando períodos
                    $mensal = $dataBase->copy()->addMonth();
                    $semestral = $dataBase->copy()->addMonths(6);
                    $anual = $dataBase->copy()->addYear();
                @endphp

                @auth
                    @if(Auth::user()->assinante_ate && \Carbon\Carbon::parse(Auth::user()->assinante_ate)->isFuture())
                        <div class="alert alert-info text-center mx-auto mb-4 shadow-sm border-0"
                            style="max-width: 700px; border-radius: 8px;">
                            <i class="fas fa-crown text-warning me-2"></i>
                            <strong>Você já é um assinante ativo!</strong><br>
                            Seu acesso atual é válido até
                            <strong>{{ \Carbon\Carbon::parse(Auth::user()->assinante_ate)->format('d/m/Y') }}</strong>.<br>
                            <small>Ao selecionar um novo plano abaixo, o tempo será <u>somado</u> à sua assinatura
                                atual.</small>
                        </div>
                    @endif
                @endauth
                <div class="row justify-content-center">
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-lg border-0 h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Plano Mensal</h5>
                                <p class="card-text text-muted" id="expiraMensal">Acesso até
                                    {{ $mensal->format('d/m/Y') }}
                                </p>
                                <h3 class="text-primary mb-4">R$ 9,90/mês</h3>
                                <button class="btn btn-primary w-100"
                                    onclick="selectPlan('Mensal', 9.90)">Selecionar</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="card shadow-lg border-0 h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Plano Semestral</h5>
                                <p class="card-text text-muted" id="expiraSemestral">Acesso até
                                    {{ $semestral->format('d/m/Y') }}
                                </p>
                                <h3 class="text-primary mb-4">R$ 49,90</h3>
                                <button class="btn btn-primary w-100"
                                    onclick="selectPlan('Semestral', 49.90)">Selecionar</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="card shadow-lg border-0 h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Plano Anual</h5>
                                <p class="card-text text-muted" id="expiraAnual">Acesso até
                                    {{ $anual->format('d/m/Y') }}
                                </p>
                                <h3 class="text-primary mb-4">R$ 89,90</h3>
                                <button class="btn btn-primary w-100"
                                    onclick="selectPlan('Anual', 89.90)">Selecionar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="paymentSection" class="mt-5 card p-4 shadow-sm border-0"
                    style="display: none; max-width: 700px; margin: 0 auto;">
                    <h4 class="text-center mb-3">
                        Plano <span id="planoSelecionadoTexto" class="fw-bold text-primary"></span> selecionado!
                        <br>Escolha a forma de pagamento:
                    </h4>

                    <div class="d-flex justify-content-center gap-4 mb-4">
                        <button class="btn btn-success px-4" onclick="showPix()">PIX</button>
                        <button class="btn btn-primary px-4" onclick="showCard()">Cartão de Crédito</button>
                    </div>

                    <div id="pixSection" class="text-center" style="display: none;">
                        <h5>Escaneie o QR Code para pagar</h5>
                        <img src="{{ asset('storage/imagens/qrcode-pix-exemplo.png') }}" alt="QR Code Pix"
                            style="width: 400px; margin: 20px auto;">
                    </div>

                    <div id="cardSection" class="col-md-8 mx-auto" style="display: none;">
                        <form action="{{ route('pagamento.processar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plano" class="planoInput" id="planoInputCard">

                            <div class="form-group mb-3">
                                <label for="cardNumber">Número do Cartão</label>
                                <input type="text" class="form-control" id="cardNumber"
                                    placeholder="1234 5678 9012 3456" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="cardName">Nome no Cartão</label>
                                <input type="text" class="form-control" id="cardName"
                                    placeholder="Nome impresso no cartão" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="expiry">Validade</label>
                                    <input type="text" class="form-control" id="expiry" placeholder="MM/AA" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cvv">CVV</label>
                                    <input type="text" class="form-control" id="cvv" placeholder="123" required>
                                </div>
                            </div>
                            <div class="d-grid mt-3">
                                <button type="submit" class="btn btn-primary btn-lg"
                                    onclick="loadingButton(this)">Finalizar Pagamento</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('layouts/footer')

    <script>
        function selectPlan(plan, price) {
            document.getElementById('paymentSection').style.display = 'block';
            document.getElementById('pixSection').style.display = 'none';
            document.getElementById('cardSection').style.display = 'none';

            document.getElementById('planoSelecionadoTexto').textContent = plan;

            let inputs = document.getElementsByClassName('planoInput');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].value = plan;
            }

            document.getElementById('paymentSection').scrollIntoView({ behavior: 'smooth' });
        }

        function showPix() {
            document.getElementById('pixSection').style.display = 'block';
            document.getElementById('cardSection').style.display = 'none';
        }

        function showCard() {
            document.getElementById('pixSection').style.display = 'none';
            document.getElementById('cardSection').style.display = 'block';
        }

        function loadingButton(btn) {
            setTimeout(function () {
                btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processando...';
                btn.classList.add('disabled');
            }, 300);
        }
    </script>
</body>

</html>