@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Mostrar Docente</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <a class="btn btn-primary" href="{{route('docentes.index')}}">Listado</a>
                        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                    </div>
                    <div class="ibox-content">
                        <form >
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Persona</label>
                                <div class="col-sm-10"><input type="text" class="form-control" value="{{$docente->persona}}" disabled=""></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Login</label>
                                <div class="col-sm-10"><input type="text" class="form-control" value="{{$docente->login}}" disabled=""></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Perfil</label>

                                <div class="col-sm-10"><input type="text" class="form-control" value="{{$docente->perfil}}" disabled=""></div>

                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Codigo_Docente</label>

                                <div class="col-sm-10"><input type="text" class="form-control" value="{{$docente->codigo_docente}}" disabled=""></div>

                            </div>




                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Activo</label>
                                <div class="col-sm-10">
                                    @if ($docente->activo) 
                                        <span class="label label-primary">SI</span> 
                                    @else 
                                        <span class="label label-warning">NO</span> 
                                    @endif    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Creado</label>
                                <div class="col-sm-10"><input type="text" class="form-control" value="{{fecha_latina($docente->created_at) }}" disabled=""></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@stop
