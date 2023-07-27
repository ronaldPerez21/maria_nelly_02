@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Modificar Gestion</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <a class="btn btn-primary" href="{{route('gestiones.index')}}">Listado</a>
                        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                    </div>
                    <div class="ibox-content">
                        <form action="{{route("gestiones.actualizar",$gestion)}}" method="post">
        
                            @csrf
                            @method('put')

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Anio:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="anio" value="{{old('anio',$gestion->anio)}}" required="">
                                </div>
                            </div>
                            @error('anio')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            {{-- comienzo --}}
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Fecha Inicio Clases:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="fecha_inicio_clases" value="{{old('fecha_inicio_clases',$gestion->fecha_inicio_clases)}}" required="">
                                </div>
                            </div>
                            @error('fecha_inicio_clases')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror
                            {{-- fin --}}
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Fecha Final Clases:<i class="text-danger">*</i></label>
                                <div class="col-sm-10"><input type="date" class="form-control" name="fecha_final_clases" value="{{old('fecha_final_clases',$gestion->fecha_final_clases)}}" required=""></div>
                            </div>
                            @error('fecha_final_clases')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Numero Periodos:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="numeros_periodos" value="{{old('numeros_periodos',$gestion->numeros_periodos)}}" required="">
                                </div>
                            </div>
                            @error('numeros_periodos')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tipos Periodos:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="tipos_periodos"  id="tipos_periodos">
                                        <option value="BI" @if(old('tipos_periodos',$gestion->tipos_periodos)=='BI') selected="" @endif>BIMESTRAL</option>
                                        <option value="TRI" @if(old('tipos_periodos',$gestion->tipos_periodos)=='TRI') selected="" @endif>TRIMESTRAL</option>
                                    </select>
                                </div>
                            </div>
                            @error('tipos_periodos')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror


                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Activo</label>
                                <div class="col-sm-10">
                                    <div class="i-checks">
                                        <label> <input type="radio" value="1" name="activo" @if(old('activo',$gestion->activo)=='1') checked="" @endif> <i></i>SI</label>
                                        <label> <input type="radio" value="0" name="activo" @if(old('activo',$gestion->activo)=='0') checked="" @endif> <i></i>NO</label>
                                    </div>
                                </div>
                            </div>
                            @error('activo')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-success " type="submit">Guardar</button>
                                    <button class="btn btn-danger " type="button" onclick="location.href='{{route('gestiones.index')}}'">Cancelar</button>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@stop