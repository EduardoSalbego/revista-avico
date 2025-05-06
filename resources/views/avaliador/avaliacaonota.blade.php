@extends('layouts.app')
@section('content')

<div class="container mt-3" >
        <h3>Avaliações</h3>
        <hr>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <th scope="col">Nota</th>
                <th scope="col">Comentarios</th>
            </thead>
            <tbody>
                @foreach($avaliacao as $a)
                    @if($a->artigo_id == $artigo_id)
                    <tr scope="row">
                        <td>{{ $a->nota }}</td>
                        <td>{{ $a->comentarios }}</td>
                    @endif
                @endforeach    
                
            </tbody>
        </table>
    </div>

    <x-footer/>
</div>
@endsection