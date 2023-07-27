@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Agregar Matricula</h2>
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
                        <form action="{{route("matriculas.insertar")}}" method="post">
                            @csrf
                                                 
                            {{-- comienzo --}}

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Estudiante:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="Estudiante" name="txtEstudiante" id="txtEstudiante" value="" class="typeahead_2 form-control" />
                                    <input type="hidden" name="id" id="id" value="{{old('id')}}">
                                    {{-- <input type="text" class="form-control" name="id" value="{{old('id')}}" required=""> --}}
                                </div>
                            </div>
                            @error('id')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror
                            {{-- fin --}}

                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Grupo:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <div id="box-load" style="display: none;">
                                        <img src="{{asset('img/ajax-loader.gif')}}">
                                    </div>
                                    <select class="form-control" name="grupo_id"  id="grupo_id">
                                        {{-- <option value="" ></option> --}}
                                    </select>
                                </div>
                            </div>
                            @error('grupo_id')
                                <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Monto:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="monto" value="{{old('monto')}}" required="">
                                </div>
                            </div>
                            @error('monto')
                            <div class="alert alert-danger alert-dismissable">{{$message}}<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                            @enderror

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Observacion:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="observacion" value="{{old('observacion')}}" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-success " type="submit">Guardar</button>
                                    <button class="btn btn-danger " type="button" onclick="location.href='{{route('matriculas.index')}}'">Cancelar</button>
                                    
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
            $('#txtEstudiante').keyup(function(){
                var nombre=$(this).val();
                if(nombre.length>=3){
                    $.get('{{route('matriculas.estudiantesActivos')}}?q='+nombre, function(data){
                        $("#txtEstudiante").typeahead(
                            { 
                                source:data,
                                afterSelect:function(item){
                                    $('#id').val(item.id);
                                    CargarGrupos(item.id);
                                }
                            }
                            );
                    },'json');    
                }else{
                    if(nombre.length==0){
                        $('#id').val('');
                    }
                }
                
            });
        });

        function CargarGrupos(estudiante_id){
            $('#box-load').show();
            $.get('{{route('matriculas.validarNotas')}}?estudiante_id='+estudiante_id, function(grupos){
                var options = '';
                $('#grupo_id option').remove();
                for(var i = 0; i <grupos.length; i++){
                    let grupo = grupos[i];
                    options = '<option value="'+grupo.id+'" >'+grupo.codigo+'</option>';
                }
                $('#grupo_id').append(options);

                $('#box-load').hide();
            },'json');
        }
    </script>
@stop
