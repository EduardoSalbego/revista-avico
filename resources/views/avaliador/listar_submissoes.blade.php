 <!-- Styles -->
 <link href="{{ asset('css/select.css') }}" rel="stylesheet" type="text/css">

 @extends('layouts.app')

 @section('content')
     <div class="container mt-3">
         <h3>Submissões</h3>
         <hr>
         <div class="pagination justify-content-center" style="color: black;">
             {{ $submissoes->links('pagination::bootstrap-4') }}
         </div>
         <div class="container" style="margin-bottom: 100px;">
             <table class="table table-borderless table-hover">
                 <thead class="table-dark">
                     <th scope="col">Revista Referenciada</th>
                     <th scope="col">Data de Submissão</th>
                     <th class="" scope="col"></th>
                 </thead>
                 <tbody>
                     @foreach ($submissoes as $submissao)
                         <tr scope="row" class="align-middle">
                             <td>{{ $submissao->revista->tituloRevista }}</td>
                             <td>{{ $submissao->created_at }}</td>
                             <td class="text-center">
                                <a class="btn btn-primary" href="{{ route('listar_artigos_submissao', $submissao->id) }}">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                            </td>
                         </tr>

                     @endforeach
                 </tbody>
             </table>
         </div>

         <x-footer />
     </div>
 @endsection
