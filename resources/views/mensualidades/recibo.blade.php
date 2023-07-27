@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Pagar Mensualidad de {{strMes($pago->mes)}}</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <a class="btn btn-primary" href="{{route('mensualidades.listado',$pago->matricula_id)}}">Mensualidades</a>
                        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                    </div>
                    <div class="ibox-content" >
                        <form action="{{route("mensualidades.pagar",$pago->id)}}" method="post">
                            @csrf
                                                 
                            {{-- comienzo --}}
                            <div id="print-area">
                                <div style="text-align: center ; width: 300px" >
                                    <strong>COLEGIO TECNICO HUMANISTICO DE CONVENIO</strong><BR>
                                    <strong>MATEO KULJIS ILIC</strong><BR>
                                    <strong>RECIBO DE PAGO DE MENSUALIDAD</strong><BR>
                                    <strong>GESTION 2021</strong><BR>
                                    <HR>
                                </div>
                                
                                <div  style="width: 300px">
                                    <strong>ESTUDIANTE:</strong><BR>
                                    <span style="padding-left:110px;">{{$pago->estudiante}}</span><BR>
                                    <strong>GRUPO:</strong><BR>
                                    <span style="padding-left:110px;">{{$pago->grupo}}</span><BR>
                                    <strong>MES:</strong><BR>
                                    <span style="padding-left:110px;">{{strMes($pago->mes)}}</span><BR>
                                    <strong>MONTO:</strong><BR>
                                    <span style="padding-left:110px;">{{$pago->monto}}</span><BR>
                                    <strong>FECHA PAGO:</strong><BR>
                                    <span style="padding-left:110px;">{{fecha_latina($pago->fecha)}}</span><BR><BR><BR>
                                </div>
                                
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-success " type="button" id="btn-imprimir">Imprimir</button>
                                    <button class="btn btn-info " type="button" onclick="location.href='{{route('mensualidades.listado',$pago->matricula_id)}}'">Volver</button>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="urlPersonasActivas">
    <script>
        $(document).ready(function(){
           $('#btn-imprimir').click(function(){
            $("div#print-area").printArea();
           });
        });

        
    </script>
@stop
