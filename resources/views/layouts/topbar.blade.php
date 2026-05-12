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
                    @if (Auth::user()->hasRole('editor') || Auth::user()->hasRole('admin'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('editor.edicoes.create') }}">nova edição</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="/assinar">assine</a>
                    </li>


                    <div class="dropdown">
                        <button class="btn btn-secondary btn-nav-drop dropdown-toggle nav-item nav-link" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            style="text-transform: uppercase;">
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            {{-- ADMIN --}}
                            @role('admin')
                                <li><a class="dropdown-item" href="{{ route('admin.usuarios.index') }}">ADMIN: Gerenciar
                                        Usuários</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.edicoes.index') }}">ADMIN: Gerenciar
                                        Edições</a></li>

                                <li><a class="dropdown-item" href="{{ route('autor.submissoes.create') }}">AUTOR: Submeter
                                        Trabalho</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('autor.submissoes.index') }}">AUTOR: Minhas
                                        Submissões</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('editor.submissoes.index') }}">EDITOR: Ver
                                        Submissões</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('revisor.pareceres.index') }}">REVISOR: Minhas
                                        Tarefas</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            @endrole

                            {{-- AUTOR --}}
                            @if (Auth::user()->autor)
                                <li><a class="dropdown-item" href="{{ route('autor.submissoes.create') }}">Submeter
                                        Trabalho</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('autor.submissoes.index') }}">Minhas
                                        Submissões</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            @endif

                            {{-- EDITOR --}}
                            @role('editor')
                                <li><a class="dropdown-item" href="{{ route('editor.submissoes.index') }}">Ver Submissões</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            @endrole

                            {{-- REVISOR --}}
                            @if (Auth::user()->revisor)
                                <li>
                                    <a class="dropdown-item
                                                          {{ !Auth::user()->revisorAprovado() ? 'disabled text-muted' : '' }}"
                                        href="{{ Auth::user()->revisorAprovado() ? route('revisor.pareceres.index') : '#' }}"
                                        @if (!Auth::user()->revisorAprovado()) onclick="return false;"
                                aria-disabled="true" @endif>

                                        @if (!Auth::user()->revisorAprovado())
                                            <i class="fas fa-lock me-1"></i>
                                        @endif
                                        Minhas Tarefas
                                    </a>
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            @endif

                            {{-- GERAL --}}
                            <li><a class="dropdown-item" href="/perfil">Perfil</a></li>
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
