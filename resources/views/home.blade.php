@extends('layouts.app')
@section('content')

<div class="container mt-5 height-100 bg-light">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @if(Session::has('error'))
                    <p style="color:red;">{{ Session::get('error') }}
                    </p>
                    @endif

                    Você está logado como [
                    @foreach (auth()->user()->roles as $role)
                        @if($loop->index == 0)
                            {{$role->name}}
                        @elseif($loop->index < count(auth()->user()->roles))
                        , {{$role->name}}
                        @else
                            {{$role->name}}
                        @endif
                    @endforeach
                    ].
                </div>
            </div>
        </div>
    </div>
</div>
<x-footer />
@endsection
