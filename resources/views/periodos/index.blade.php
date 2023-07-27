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
                    <a class="btn btn-primary" href="{{route('periodos.agregar')}}">Agregar</a>
                    <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                </div>
                <div class="ibox-content">
                    <form name="formBuscar" action="{{route("periodos.index")}}" method="get">
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
                                <th>Fecha inico</th>
                                <th>Fecha final</th>
                                <th>Numero periodo</th>
                                <th>Gestion</th>
                                <th>Activo</th> 
                                <th>Creado</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($periodos as $periodo)
                                <tr>
                                    <td>{{$periodo->id}}</td>
                                    <td>{{fecha_latina($periodo->fecha_inicio)}}</td>                                    
                                    <td>{{fecha_latina($periodo->fecha_fin)}}</td>
                                    <td>{{($periodo->numero)}}</td>
                                    <td>{{($periodo->gestion)}}</td>
                                    <td>
                                        @if ($periodo->activo) 
                                            <span class="label label-primary">SI</span> 
                                        @else 
                                            <span class="label label-warning">NO</span> 
                                        @endif
                                    </td>
                                    <td>{{fecha_latina($periodo->created_at) }}</td>
                                    <td data-texto="{{$periodo->fecha_inicio}}">
                                        <a href="{{route('periodos.mostrar',$periodo->id)}}" title="Mostrar"><img width="17px" src="{{asset('img/iconos/mostrar.png')}}" alt="Mostrar"></a>
                                        <a href="{{route('periodos.modificar',$periodo->id)}}" title="Modificar"><img width="17px" src="{{asset('img/iconos/modificar.png')}}" alt="Modificar"></a>
                                        <a data-periodo="{{route('periodos.eliminar',$periodo->id)}}" class="btn-eliminar" title="Eliminar"><img width="17px" src="{{asset('img/iconos/eliminar.png')}}" alt="Eliminar"></a>
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
                                    var periodo=$(this).data('periodo');
                                    var texto = $(this).closest('td').data('texto');
                                    var esEliminar = confirm('Esta seguro de eliminar el registro "'+(texto)+'"');
                                    if(esEliminar){
                                        $('#formEliminar').attr('action',periodo);
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
