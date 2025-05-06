 <!-- Styles -->
 <link href="{{ asset('css/select.css') }}" rel="stylesheet" type="text/css">
<?php 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
?>
 @extends('layouts.app')

 @section('content')
     <div class="container mt-3">
         <h3>Artigos Submetidos</h3>
         <hr>
         <div class="pagination justify-content-center" style="color: black;">
             {{-- {{ $submissoes->links('pagination::bootstrap-4') }} --}}
         </div>
         <div class="container" style="margin-bottom: 100px;">
             <table class="table table-borderless table-hover">
                 <thead class="table-dark">
                     <th scope="col">Artigo</th>
                     <th scope="col">Data de Submissão</th>
                     <th scope="col">Data Final da Avaliacao</th>
                     <th class="" scope="col"></th>
                 </thead>
                 <tbody>
                     <?php
                     $id = Auth::id();
                     $avaliador = DB::table('avaliadors')
                         ->where('user_id', $id)
                         ->first(); ?>
                     @foreach ($submissoes as $submissao)
                         <tr scope="row" class="align-middle">

                             <?php $artigo = DB::table('artigos')
                                 ->where('id', $submissao->artigo_id)
                                 ->first();

                             $artigoavaliador = DB::table('artigoavaliador')
                                 ->where('avaliador_id', $avaliador->id)
                                 ->get();

                             $avaliacao = DB::table('avaliacao')
                                 ->where('avaliador_id', $id)
                                 ->first();

                             $submissao_id = DB::table('Submissao')
                                 ->where('id', $submissao->submissao_id)
                                 ->first();

                             $periodo = DB::table('PeriodoChamada')
                                 ->where('revista_id', $submissao_id->revista_id)
                                 ->first();

                             ?>

                             @foreach ($artigoavaliador as $result)
                                 @if ($result->artigo_id == $artigo->id)
                                     <?php
                                     $a = DB::table('avaliacao')
                                     ->where('avaliador_id', $avaliador->id)
                                     ->where('artigo_id', $result->artigo_id)
                                     ->first();

                                     ?>
                                     <td>{{ $artigo->tituloArtigo }}</td>
                                     <td>{{ $artigo->created_at }}</td>
                                     <td>{{ $periodo->dataMaximaAvaliacao }}</td>
                                     <td class="text-center">
                                         <a class="btn btn-primary"
                                             href="{{ route('avaliar.artigo', $artigo->id) }}">
                                             <i class="fa fa-check-square" aria-hidden="true"></i>
                                         </a>
                                         <a class="btn btn-primary"
                                             href="{{ route('avaliarartigo', $artigo->id) }}">
                                             <i class="fa fa-eye" aria-hidden="true"></i>
                                         </a>
                                     </td>
                                 @endif
                             @endforeach
                         </tr>


                     @endforeach
                 </tbody>
             </table>
         </div>
         <x-footer />
     </div>


 @endsection
