@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Agregar Periodo</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <a class="btn btn-primary" href="{{route('periodos.index')}}">Listado</a>
                        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                    </div>
                    <div class="ibox-content">
                        <form action="{{route("periodos.insertar")}}" method="post">
                            @csrf
                                                 
                            {{-- comienzo --}}
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Fecha Inicio:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="fecha_inicio" value="{{old('fecha_inicio')}}" required="">
                                </div>
                            </div>
                            @error('fecha_inicio')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror
                            {{-- fin --}}
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Fecha Final:<i class="text-danger">*</i></label>
                                <div class="col-sm-10"><input type="date" class="form-control" name="fecha_fin" value="{{old('fecha_fin')}}" required=""></div>
                            </div>
                            @error('fecha_fin')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror


                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Numero de periodo:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="numero" value="{{old('numero')}}" required="">
                                </div>
                            </div>
                            @error('numero')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Gestion:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="gestion_id"  id="gestion_id">
                                        <option value="" ></option>
                                        @foreach ($gestiones as $gestion)
                                            <option value="{{$gestion->id}}" >{{$gestion->anio}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('gestion_id')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Activo</label>
                                <div class="col-sm-10">
                                    <div class="i-checks">
                                        <label> <input type="radio" value="1" name="activo" @if(old('activo')=='1') checked="" @endif> <i></i>SI</label>&nbsp;&nbsp;
                                        <label> <input type="radio" value="0" name="activo" @if(old('activo')=='0') checked="" @endif> <i></i>NO</label>
                                    </div>
                                </div>
                            </div>
                            @error('activo')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-success " type="submit">Guardar</button>
                                    <button class="btn btn-danger " type="button" onclick="location.href='{{route('periodos.index')}}'">Cancelar</button>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@stop
