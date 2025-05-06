@extends('layouts.app')

@section('content')
<!-- Chamados Modal -->
<div class="modal fade" id="chamados" tabindex="-1" aria-labelledby="modal2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal2">Períodos de Chamado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                
            @foreach($periodos_de_chamado as $chamado)
                <?php echo $periodos_de_chamado ?>
                <div class="row card rounded shadow m-3 pb-4 pt-4 text-center">                                                                  
                    <div class="row d-flex text-center  justify-content-center">
                        <label class="col-4 fw-bold fs-10">Data Inicio</label><label class="col-4 fw-bold fs-10">Data Final</label>                                  
                        <div class="row justify-content-center text-center">
                            <span class="col-4">{{ date('d/m/y', strtotime($chamado->dataInicio)) }}</span>
                            <span class="col-4">{{  date('d/m/y', strtotime($chamado->dataFinal)) }}</span> 
                        </div>                                
                    </div>
                    <div class="row d-flex text-center mt-2 justify-content-center">
                        <small>
                        <span class="col col-4 text-center">
                            <span class="fs-10">Divulgado em</span>
                            {{ date('d/m/y', strtotime($chamado->dataDivulgacao)) }}
                        </span>
                        -
                        <span class="col col-4 text-center">
                            <span class="fs-10">Avaliações até</span>
                            {{ date('d/m/y', strtotime($chamado->dataMaximaAvaliacao)) }}
                        </span>
                        </small>
                    </div>
                </div>
            @endforeach                           
            </div>
        </div>
    </div>   
</div> 
@endsection