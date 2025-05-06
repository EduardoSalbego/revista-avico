 <!-- Styles -->
 <link href="{{ asset('css/select.css') }}" rel="stylesheet" type="text/css">
<?php 
use Illuminate\Support\Facades\Storage;
?>
@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <h3>Submissões Pendentes</h3>
    <hr>
    <h6 class="text-center" id="obrigatorio"><small>{!! session()->get('erro004') !!}</small></h6>
    <div class="pagination justify-content-center" style="color: black;">
            {{ $submissoes->links("pagination::bootstrap-4") }}
    </div>
    <div class="container" style="margin-bottom: 100px;">
        <table style="transition:none !important;" class="table table-borderless table-hover">
            <thead class="table-dark">
                <th scope="col">Revista</th>
                <th scope="col">Artigos</th>
                <th scope="col">Status</th>
                <th scope="col">Autores</th>
                <th scope="col">Data de Submissão</th>
                <th class="" scope="col"></th>
            </thead>
            <tbody>
               
                @foreach($submissoes as $submissao)
                <tr scope="row" class="align-middle">

                    <td><p class="text-center">{{ $submissao->revista->tituloRevista}}</p></td>
                    <td class="col col-3">
                    @foreach($submissao->artigos as $artigo)
                        <a href="{{ $artigo->caminhoArtigo }}" >
                            <small><p class="articles mb-1 text-center p-1">{{ $artigo->tituloArtigo }}</br></p></small>
                        </a>
                        
                    @endforeach
                    </td>
                    <td class="col-2">
                    @foreach($submissao->artigos as $artigo)
                    <?php if($artigo->nota != 0){?>
                        <small><p class="status mb-1 text-center p-1">{{ $artigo->situacao->descricaoSituacao . " (" . $artigo->nota  . ") " }}</br></p></small>
                    <?php }else{ ?>

                        <small><p class="status mb-1 text-center p-1">{{ $artigo->situacao->descricaoSituacao }}</br></p></small>
                    <?php } ?>
                    @endforeach
                    </td>

                    <td>    
                        @isset($submissao->artigos[0])                   
                            @foreach($submissao->artigos[0]->autores as  $autor)
                                <small><p class="selected-author p-1 mb-1 text-center">{{ $autor->user->name }}</br></p></small>
                            @endforeach
                        @endisset

                    </td>

                    <td><p class="text-center">{{ date('d/m/Y H:i:s', strtotime($submissao->created_at)) }}</p></td>

                    <td class="text-center">
                        <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#del-modal-{{ $submissao->id }}">
                            <i class="fa fa-times" style="transition:none !important;" aria-hidden="true"></i>
                        </a>
                    </td>
                    <!-- Modal -->
                    <div class="modal fade" id="del-modal-{{ $submissao->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Deseja mesmo cancelar a submissão?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" >
                                    <a href="{{ route('delete.submissao', $submissao->id) }}" style="color: white;text-decoration: none;">Sim</a>
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
