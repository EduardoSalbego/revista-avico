<!DOCTYPE html>
<html lang="pt-br">

@include('layouts/head')

<body id="page-top">

    @include('layouts/topbar')

    <main id="content" style="margin-bottom: 113px;">
        <section class="page-section">
            <div class="container mt-5 pt-5">
                <div class="text-center mb-4" style="margin-top: -60px;">
                    <h2>Assine a</h2>
                    <img src="storage/app/public/imagens/revico_texto.png" alt="Logo REVICO"
                        style="height: 40px; margin-bottom: 20px;">
                </div>
                <p class="text-center text-muted mb-5">Escolha o melhor plano para você e tenha acesso a todas
                    as edições exclusivas da revista!</p>

                @php
                    // Data atual
                    $hoje = now();

                    // Somando períodos
                    $mensal = $hoje->copy()->addMonth();
                    $semestral = $hoje->copy()->addMonths(6);
                    $anual = $hoje->copy()->addYear();
                @endphp

                <div class="row justify-content-center">
                    <!-- Planos -->
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-lg border-0 h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Plano Mensal</h5>
                                <p class="card-text text-muted" id="expiraMensal">Acesso até
                                    {{ $mensal->format('d/m/Y') }}</p>
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
                                    {{ $semestral->format('d/m/Y') }}</p>
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
                                    {{ $anual->format('d/m/Y') }}</p>
                                <h3 class="text-primary mb-4">R$ 89,90</h3>
                                <button class="btn btn-primary w-100"
                                    onclick="selectPlan('Anual', 89.90)">Selecionar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulário de pagamento -->
                <div id="paymentSection" class="mt-5" style="display: none;">
                    <h4 class="text-center mb-3">
                        Plano <span id="planoSelecionadoTexto" class="fw-bold text-primary"></span> selecionado!
                        <br>Escolha a forma de pagamento:
                    </h4>

                    <div class="d-flex justify-content-center gap-4 mb-4">
                        <button class="btn btn-success" onclick="showPix()">PIX</button>
                        <button class="btn btn-primary" onclick="showCard()">Cartão</button>
                    </div>

                    <!-- Pagamento Pix -->
                    <div id="pixSection" class="text-center" style="display: none;">
                        <h5>Escaneie o QR Code para pagar</h5>
                        <img src="/storage/app/public/imagens/qrcode-pix-exemplo.png" alt="QR Code Pix"
                            style="width: 200px; margin: 20px auto;">
                        <p class="text-muted">Após o pagamento, o acesso será liberado automaticamente.</p>
                    </div>

                    <!-- Pagamento com Cartão -->
                    <div id="cardSection" class="col-md-6 mx-auto" style="display: none;">
                        <form action="/processar_pagamento" method="POST">
                            @csrf
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
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Finalizar Pagamento</button>
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
            window.selectedPlan = plan;
            document.getElementById('planoSelecionadoTexto').textContent = plan;
        }

        function showPix() {
            document.getElementById('pixSection').style.display = 'block';
            document.getElementById('cardSection').style.display = 'none';
        }

        function showCard() {
            document.getElementById('pixSection').style.display = 'none';
            document.getElementById('cardSection').style.display = 'block';
        }
    </script>
</body>

</html>