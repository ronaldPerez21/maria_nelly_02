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
                <div class="ibox-title">
                    <a class="btn btn-primary" href="{{route('matriculas.agregar')}}">Agregar</a>
                    <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                </div>
                <div class="ibox-content">
                    <form name="formBuscar" action="{{route("matriculas.index")}}" method="get">
                        <div class="row">
                            <div class="col-sm-3 m-b-xs">
                                <div class="input-group">
                                    <input placeholder="Buscar" type="text" class="form-control form-control-sm" name="buscar" value="{{$buscar}}"> 
                                    <span class="input-group-append"> <button type="submit" class="btn btn-sm btn-success">Buscar</button> </span>
                                </div>
                            </div>
                            <div class="col-sm-7 m-b-xs" >&nbsp;</div>
                            <div class="col-sm-2 m-b-xs" style="float: right;">{{paginacion($parPaginacion)}}</div>
                        </div>
                    </form>
                    <div class="row"><div class="col-sm-12 m-b-xs"><span class="text-success">Total: <strong>{{$total}}</strong></span></div></div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Estudiante</th>
                                <th>Monto</th>
                                <th>Gestion</th>
                                <th>Fecha</th>
                                <th>Grupo</th>
                                <th>observacion</th>
                                <th>Anulado</th> 
                                <th>Creado</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($matriculas as $matricula)
                                <tr>
                                    <td>{{$matricula->id}}</td>
                                    <td>{{($matricula->estudiante)}}</td>                                     
                                    <td>{{($matricula->monto)}}</td>
                                    <td>{{($matricula->gestion)}}</td>
                                    <td>{{fecha_latina($matricula->fecha)}}</td>
                                    <td>{{($matricula->grupo)}}</td>
                                    <td>{{($matricula->observacion)}}</td>
                                    <td>
                                        @if ($matricula->anulado) 
                                            <span class="label label-primary">SI</span> 
                                        @else 
                                            <span class="label label-warning">NO</span> 
                                        @endif
                                    </td>
                                    <td>{{fecha_latina($matricula->created_at) }}</td>
                                    <td data-texto="{{$matricula->fecha}}">
                                        <a href="{{route('matriculas.mostrar',$matricula->id)}}" title="Mostrar"><img width="17px" src="{{asset('img/iconos/mostrar.png')}}" alt="Mostrar"></a>
                                        <a data-matricula="{{route('matriculas.anular',$matricula->id)}}" class="btn-eliminar" title="Eliminar"><img width="17px" src="{{asset('img/iconos/eliminar.png')}}" alt="Eliminar"></a>
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
                                    var matricula=$(this).data('matricula');
                                    var texto = $(this).closest('td').data('texto');
                                    var esEliminar = confirm('Esta seguro de eliminar el registro "'+(texto)+'"');
                                    if(esEliminar){
                                        $('#formEliminar').attr('action',matricula);
                                        document.formEliminar.submit();
                                    }
                                    
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
