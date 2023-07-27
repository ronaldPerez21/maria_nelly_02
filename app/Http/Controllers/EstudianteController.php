<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Persona;

use App\Libs\Funciones;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public $parControl=[
        'modulo'=>'academico',
        'funcionalidad'=>'estudiantes',
        'titulo' =>'Estudiantes',
    ];

    public function index(Request $request)
    {
        $estudiante = new Estudiante();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $estudiante->obtenerEstudiantes($buscar,$pagina);
        $mergeData = [
            'estudiantes'=>$resultado['estudiantes'],
            'total'=>$resultado['total'],
            'buscar'=>$buscar,
            'parPaginacion'=>$resultado['parPaginacion'],
            'parControl'=>$this->parControl
        ];
        return view('estudiantes.index',$mergeData);
    }
    
    public function mostrar($id)
    {
        $estudiante = Estudiante::getEstudiante($id);
        
        $mergeData = ['id'=>$id,'estudiante'=>$estudiante,'parControl'=>$this->parControl];
        return view('estudiantes.mostrar',$mergeData);
    }

    public function agregar()
    { 
        $mergeData = ['parControl'=>$this->parControl];
        return view('estudiantes.agregar',$mergeData);  
    }

    public function insertar(Request $request)
    {
        $request->validate([
          'id'=>'required',
          'codigo_rude'=>'required|max:30',
          'activo'=>'required',
        ]);
        $persona = Persona::find($request->id);
        $estudiante = new Estudiante();
        $estudiante->id = $request->id;
        $estudiante->login = $persona->ci;
        $estudiante->pass = md5($persona->ci) ;
        $estudiante->perfil_id = Estudiante::getIdPerfilEstudiante();
        $estudiante->codigo_rude = $request->codigo_rude;

        $estudiante->activo = $request->activo?true:false;
        $estudiante->save();

        return redirect()->route('estudiantes.mostrar',$request->id);
    }

    public function modificar($id)
    {
        $estudiante = Estudiante::find($id);

        $oPersona = new Persona();
        $nombrePersona = $oPersona->getNombreCompleto($id);

        $mergeData = ['id'=>$id,'estudiante'=>$estudiante,'nombreCompleto'=>$nombrePersona,'parControl'=>$this->parControl];
        return view('estudiantes.modificar',$mergeData);
    }

    public function actualizar(Request $request, Estudiante $estudiante)
    {
        $request->validate([
            'codigo_rude'=>'required|max:30',
            'activo'=>'required',
        ]);
        $estudiante->codigo_rude = $request->codigo_rude;
        $estudiante->activo = $request->activo?true:false;
        $estudiante->save();

        return redirect()->route('estudiantes.mostrar',$estudiante->id);
    }

    public function eliminar($id)
    {
        $estudiante = Estudiante::find($id);
        $estudiante->eliminado=true;
        $estudiante->save();
        return redirect()->route('estudinates.index');
    }

    public function personasActivas(Request $request)
    {
        $buscar=$request->q;
        $estudiante = new Estudiante();
        $personas = $estudiante->buscarPersonas($buscar);
        $resultado=[];
        foreach ($personas as $persona){
            $resultado[]=(object)['name'=>$persona->nombre,'id'=>$persona->id];
        }
        return json_encode($resultado);
    }
}
