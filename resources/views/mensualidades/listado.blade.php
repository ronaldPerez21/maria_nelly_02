@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>{{$parControl['titulo']}}</h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row" >
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Estudiante</label>
                        <div class="col-sm-10"><input type="text" class="form-control" value="{{$info->estudiante}}" disabled=""></div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Grupo</label>
                        <div class="col-sm-10"><input type="text" class="form-control" value="{{$info->codigo}}" disabled=""></div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Mes</th>
                                <th>Monto</th>
                                <th>F. Vencimiento</th>
                                <th>Pagado</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mensualidades as $mensualidad)
                                <tr>
                                    <td>{{$mensualidad->id}}</td>
                                    <td >{{strMes($mensualidad->mes)}}</td>
                                    <td>{{($mensualidad->monto)}}</td>
                                    <td >{{fecha_latina($mensualidad->fecha_vencimiento)}}</td>
                                    <td>
                                        @if ($mensualidad->pago_id) 
                                            <span class="label label-primary">SI</span> 
                                        @else 
                                            <span class="label label-warning">NO</span> 
                                        @endif
                                    </td>
                                    <td data-texto="">
                                        @if ($mensualidad->pago_id) 
                                            <a href="{{route('mensualidades.recibo',$mensualidad->id)}}" title="Recibo"><img width="17px" src="{{asset('img/iconos/recibo.png')}}" alt="Recibo"></a>
                                        @else
                                            <a href="{{route('mensualidades.pagar',$mensualidad->id)}}" title="Pagar"><img width="17px" src="{{asset('img/iconos/pagar.png')}}" alt="Pagar"></a>
                                        @endif
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <form name="formEliminar" id="formEliminar"  action="" method="post">
                            @csrf
                            @method('delete')
                            <input type="submit" value="Eliminar" hidden="">
                        </form>
                        <script>
                            $(document).ready(function(){
                                $('.btn-eliminar').click(function(){
                                    // var matricula=$(this).data('matricula');
                                    // var texto = $(this).closest('td').data('texto');
                                    // var esEliminar = confirm('Esta seguro de eliminar el registro "'+(texto)+'"');
                                    // if(esEliminar){
                                    //     $('#formEliminar').attr('action',matricula);
                                    //     document.formEliminar.submit();
                                    // }
                                });
                                
                            });
                        </script>                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
