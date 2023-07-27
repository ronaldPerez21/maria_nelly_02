@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Modificar Grupo</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <a class="btn btn-primary" href="{{route('grupos.index')}}">Listado</a>
                        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                    </div>
                    <div class="ibox-content">
                        <form action="{{route("grupos.actualizar",$grupo)}}" method="post">
        
                            @csrf
                            @method('put')
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nombre:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nombre" value="{{old('nombre',$grupo->nombre)}}" required="">
                                </div>
                            </div>
                            @error('nombre')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror
                            {{-- fin --}}
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Codigo:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="codigo" value="{{old('codigo',$grupo->codigo)}}" required="">
                                </div>
                            </div>
                            @error('codigo')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Cupos:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="cupos" value="{{old('cupos',$grupo->cupos)}}" required="">
                                </div>
                            </div>
                            @error('cupos')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror


                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Gestion:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="gestion_id"  id="gestion_id">
                                        <option value="" ></option>
                                        @foreach ($gestiones as $gestion)
                                        <option value="{{$gestion->id}}" @if(old('gestion_id',$grupo->gestion_id)==$gestion->id) selected="" @endif >{{$gestion->anio}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('gestion_id')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror


                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Turno:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="turno_id"  id="turno_id">
                                        <option value="" ></option>
                                        @foreach ($turnos as $turno)
                                        <option value="{{$turno->id}}" @if(old('turno_id',$grupo->turno_id)==$turno->id) selected="" @endif >{{$turno->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('turno_id')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Grado:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="grado_id"  id="grado_id">
                                        <option value="" ></option>
                                        @foreach ($grados as $grado)
                                        <option value="{{$grado->id}}" @if(old('grado_id',$grupo->grado_id)==$grado->id) selected="" @endif >{{$grado->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('grado_id')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Aula:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="aula_id"  id="aula_id">
                                        <option value="" ></option>
                                        @foreach ($aulas as $aula)
                                            <option value="{{$aula->id}}" @if(old('aula_id',$grupo->aula_id)==$aula->id) selected="" @endif >{{$aula->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('aula_id')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror


                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Activo</label>
                                <div class="col-sm-10">
                                    <div class="i-checks">
                                        <label> <input type="radio" value="1" name="activo" @if(old('activo',$grupo->activo)=='1') checked="" @endif> <i></i>SI</label>
                                        <label> <input type="radio" value="0" name="activo" @if(old('activo',$grupo->activo)=='0') checked="" @endif> <i></i>NO</label>
                                    </div>
                                </div>
                            </div>
                            @error('activo')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-success " type="submit">Guardar</button>
                                    <button class="btn btn-danger " type="button" onclick="location.href='{{route('grupos.index')}}'">Cancelar</button>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@stop