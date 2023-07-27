<?php

namespace App\Http\Controllers;
use App\Models\Matricula;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Models\Nota;
use App\Models\Mensualidad;
use App\Libs\Funciones;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    public $parControl=[
        'modulo'=>'inscripcion',
        'funcionalidad'=>'matriculas',
        'titulo' =>'Matriculas',
    ];

    public function index(Request $request)
    {
        $matricula = new Matricula();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $matricula->obtenerMatriculas($buscar,$pagina);
        $mergeData = [
            'matriculas'=>$resultado['matriculas'],
            'total'=>$resultado['total'],
            'buscar'=>$buscar,
            'parPaginacion'=>$resultado['parPaginacion'],
            'parControl'=>$this->parControl
        ];
        return view('matriculas.index',$mergeData);
    }
    
    public function mostrar($id)
    {
        $matricula = Matricula::getMatricula($id);
        $mensualidad = new Mensualidad();
        $mensualidades = $mensualidad->ObtenerMensualidades($matricula->id);

        $mergeData = ['id'=>$id,'matricula'=>$matricula,'mensualidades'=>$mensualidades,'parControl'=>$this->parControl];
        return view('matriculas.mostrar',$mergeData);
    }

    public function agregar()
    { 
        $mergeData = ['parControl'=>$this->parControl];
        return view('matriculas.agregar',$mergeData);  
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'monto'=>'required|max:30',
            'id'=>'required|max:30',
            'grupo_id'=>'required'
        ]);

        $matricula = new Matricula();
        $matricula->fecha = date('Y-m-d');
        $matricula->monto = $request->monto;
        $matricula->estudiante_id = $request->id;
        $matricula->grupo_id = $request->grupo_id;
        $matricula->observacion = $request->observacion;
        $matricula->anulado = false;
        $matricula->save();
        $mensualidad = new Mensualidad();
        $mensualidad->GenerarMensualidades($matricula->id);
        return redirect()->route('matriculas.mostrar',$matricula->id);
    }

    public function estudiantesActivos(Request $request)
    {
        $buscar=$request->q;
        $estudiante = new Estudiante();
        $estudiantes = $estudiante->BuscarEstudiantesActivos($buscar);
        $resultado=[];
        foreach ($estudiantes as $persona){
            $resultado[]=(object)['name'=>$persona->nombre,'id'=>$persona->id];
        }
        return json_encode($resultado);
    }
    
    public function validarNotas(Request $request)
    {
        $estudiante_id=$request->estudiante_id;
        $nota = new Nota();
        $grado_aprobado_id = $nota->ValidarNotasEstudiante($estudiante_id);
        $grupo = new Grupo();
        $grupos = $grupo->ObtenerGruposValidos($grado_aprobado_id);

        $resultado=[];
        foreach ($grupos as $grupo){
            $resultado[]=(object)['codigo'=>$grupo->codigo,'id'=>$grupo->id];
        }
        return json_encode($resultado);
    }

/*
    public function eliminar($id)
    {
        $matricula = Matricula::find($id);
        $matricula->eliminado=true;
        $matricula->save();
        return redirect()->route('matriculas.index');
    }
    */
}
