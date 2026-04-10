<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('storage/imagens/logo_revista_com_texto.png') }}" alt="Logo REVICO"
                style="height: 60px;"></a>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('edicoes.index') }}">EDIÇÕES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/">Autores e Colaboradores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/sobre_nos">Sobre a Revico</a>
                </li>
                @auth
                    @if (in_array(Auth::user()->role, ['admin', 'colaborador']))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('edicoes.create') }}">nova edição</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/assinar">assine</a>
                        </li>
                    @endif


                    <div class="dropdown">
                        <button class="btn btn-secondary btn-nav-drop dropdown-toggle nav-item nav-link" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            style="text-transform: uppercase;">
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @if(Auth::user()->role === 'admin')
                                <li><a class="dropdown-item" href="/admin/usuarios">Gerenciar Usuários</a></li>
                                <li><a class="dropdown-item" href="/admin/edicoes">Gerenciar Edições</a></li>
                            @endif

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/perfil">Editar Perfil</a></li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="dropdown-item" type="submit" class="dropdown-item">SAIR</button>
                            </form>
                        </ul>
                    </div>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>