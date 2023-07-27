@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Mostrar Periodo</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <a class="btn btn-primary" href="{{route('matriculas.index')}}">Listado</a>
                        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                    </div>
                    <div class="ibox-content">
                        <form >
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Persona</label>
                                <div class="col-sm-10"><input type="text" class="form-control" value="{{$matricula->estudiante}}" disabled=""></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Monto Matricula</label>
                                <div class="col-sm-10"><input type="text" class="form-control" value="{{$matricula->monto}}" disabled=""></div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Grupo</label>
                                <div class="col-sm-10"><input type="text" class="form-control" value="{{$matricula->grupo}}" disabled=""></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Creado</label>
                                <div class="col-sm-10"><input type="text" class="form-control" value="{{fecha_latina($matricula->created_at) }}" disabled=""></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Mensualidades</label>
                                <div class="col-sm-10">
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th scope="col">Mes</th>
                                            <th scope="col">Vencimiento</th>
                                            <th scope="col">Monto</th>
                                            <th scope="col">Pagado</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($mensualidades as $mensualidad)
                                                <tr>
                                                    <td >{{strMes($mensualidad->mes)}}</td>
                                                    <td >{{fecha_latina($mensualidad->fecha_vencimiento)}}</td>
                                                    <td >{{$mensualidad->monto}}</td>
                                                    <td >
                                                        @if($mensualidad->pagado)
                                                            <span class="bg-primary text-white">&nbsp;SI&nbsp;</span>
                                                        @else
                                                            <span class="bg-warning text-white">&nbsp;NO&nbsp;</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                      </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@stop
