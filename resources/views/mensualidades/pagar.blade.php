@extends('layouts.master')
@section('titulo', $parControl['titulo'])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Pagar Mensualidad de {{strMes($mensualidad->mes)}}</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <a class="btn btn-primary" href="{{route('mensualidades.listado',$mensualidad->matricula_id)}}">Mensualidades</a>
                        <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
                    </div>
                    <div class="ibox-content">
                        <form action="{{route("mensualidades.pagar",$mensualidad->id)}}" method="post">
                            @csrf
                                                 
                            {{-- comienzo --}}

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Estudiante:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="Estudiante" name="txtEstudiante" id="txtEstudiante" value="{{$mensualidad->estudiante}}" class="typeahead_2 form-control" disabled=""/>
                                    <input type="hidden" name="id" id="id" value="{{$mensualidad->id}}">
                                    
                                </div>
                            </div>
                                
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Grupo:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{$mensualidad->grupo}}" disabled="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Fecha Vencimiento:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{fecha_latina($mensualidad->fecha_vencimiento)}}" disabled="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Mes:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{strMes($mensualidad->mes)}}" disabled="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Monto:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{$mensualidad->monto}}" disabled="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Fecha Pago:<i class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{date('d/m/Y')}}" disabled="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Observacion:</label>
                                <div class="col-sm-10">
                                    <textarea name="observacion" id="observacion"  class="form-control" name="observacion"></textarea>
                                </div>
                            </div>
                            

                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-success " type="submit">Guardar</button>
                                    <button class="btn btn-danger " type="button" onclick="location.href='{{route('mensualidades.listado',$mensualidad->matricula_id)}}'">Cancelar</button>
                                    
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
                    $.get('{{route('mensualidades.estudiantesActivos')}}?q='+nombre, function(data){
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
            $.get('{{route('mensualidades.validarNotas')}}?estudiante_id='+estudiante_id, function(grupos){
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
