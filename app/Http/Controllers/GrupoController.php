<?php

namespace App\Http\Controllers;
use App\Models\Grupo;
use App\Models\Gestion;
use App\Models\Turno;
use App\Models\Grado;
use App\Models\Aula;
use App\Libs\Funciones;
use Carbon\Carbon;
use Illuminate\Http\Request;


class GrupoController extends Controller
{
    public $parControl=[
        'modulo'=>'academico',
        'funcionalidad'=>'grupos',
        'titulo' =>'Grupos',
    ];

    public function index(Request $request)
    {
        $grupo = new Grupo();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $grupo->obtenerGrupos($buscar,$pagina);
        $mergeData = [
            'grupos'=>$resultado['grupos'],
            'total'=>$resultado['total'],
            'buscar'=>$buscar,
            'parPaginacion'=>$resultado['parPaginacion'],
            'parControl'=>$this->parControl
        ];
        return view('grupos.index',$mergeData);
    }
    public function mostrar($id)
    {
        $grupo = Grupo::getGrupo($id);
        $mergeData = ['id'=>$id,'grupo'=>$grupo,'parControl'=>$this->parControl];
        return view('grupos.mostrar',$mergeData);
    }

    public function agregar()
    { 
        $gestion= new Gestion();
        $gestiones = $gestion->obtenerGestionesActivos();

        $turno= new Turno();
        $turnos = $turno->obtenerTurnosActivos();

        $grado= new Grado();
        $grados = $grado->obtenerGradosActivos();

        $aula= new Aula();
        $aulas = $aula->obtenerAulasActivas();

        $mergeData = ['parControl'=>$this->parControl, 'gestiones'=>$gestiones, 'turnos'=>$turnos, 'grados'=>$grados, 'aulas'=>$aulas];

        return view('grupos.agregar',$mergeData);  
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'codigo'=>'required|max:30',
            'nombre'=>'required|max:30',
            'cupos'=>'required|max:30',
            'gestion_id'=>'required',
            'turno_id'=>'required',
            'grado_id'=>'required',
            'aula_id'=>'required',
            'activo'=>'required',
        ]);

        $grupo = new Grupo();
        $grupo->codigo = $request->codigo;
        $grupo->nombre = $request->nombre;
        $grupo->cupos = $request->cupos;
        $grupo->gestion_id = $request->gestion_id;
        $grupo->turno_id = $request->turno_id;
        $grupo->grado_id = $request->grado_id;
        $grupo->aula_id = $request->aula_id;

        $grupo->activo = $request->activo?true:false;
        $grupo->save();
        return redirect()->route('grupos.mostrar',$grupo->id);
    }

    public function modificar($id)
    {
        
        $grupo = Grupo::find($id);

        $gestion= new Gestion();
        $gestiones = $gestion->obtenerGestionesActivos();

        $turno= new Turno();
        $turnos = $turno->obtenerTurnosActivos();

        $grado= new Grado();
        $grados = $grado->obtenerGradosActivos();

        $aula= new Aula();
        $aulas = $aula->obtenerAulasActivas();

        $mergeData = ['parControl'=>$this->parControl, 'grupo'=>$grupo, 'gestiones'=>$gestiones, 'turnos'=>$turnos, 'grados'=>$grados, 'aulas'=>$aulas];
        return view('grupos.modificar',$mergeData);
    }

    public function actualizar(Request $request, Grupo $grupo)
    {
        $request->validate([
            'codigo'=>'required|max:30',
            'nombre'=>'required|max:30',
            'cupos'=>'required|max:30',
            'gestion_id'=>'required',
            'turno_id'=>'required',
            'grado_id'=>'required',
            'aula_id'=>'required',

            'activo'=>'required',
        ]);

        $grupo->codigo = $request->codigo;
        $grupo->nombre = $request->nombre;
        $grupo->cupos = $request->cupos;
        $grupo->gestion_id = $request->gestion_id;
        $grupo->turno_id = $request->turno_id;
        $grupo->grado_id = $request->grado_id;
        $grupo->aula_id = $request->aula_id;

        $grupo->activo = $request->activo?true:false;
        $grupo->save();
        return redirect()->route('grupos.mostrar',$grupo->id);
    }

    public function eliminar($id)
    {
        $grupo = Grupo::find($id);
        $grupo->eliminado=true;
        $grupo->save();
        return redirect()->route('grupos.index');
    }
}
