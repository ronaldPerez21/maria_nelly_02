<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Persona;

use App\Libs\Funciones;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public $parControl=[
        'modulo'=>'academico',
        'funcionalidad'=>'docentes',
        'titulo' =>'Docentes',
    ];

    public function index(Request $request)
    {
        $docente = new Docente();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $docente->obtenerDocentes($buscar,$pagina);
        $mergeData = [
            'docentes'=>$resultado['docentes'],
            'total'=>$resultado['total'],
            'buscar'=>$buscar,
            'parPaginacion'=>$resultado['parPaginacion'],
            'parControl'=>$this->parControl
        ];
        return view('docentes.index',$mergeData);
    }
    
    public function mostrar($id)
    {
        $docente = Docente::getDocente($id);
        
        $mergeData = ['id'=>$id,'docente'=>$docente,'parControl'=>$this->parControl];
        return view('docentes.mostrar',$mergeData);
    }

    public function agregar()
    { 
        $mergeData = ['parControl'=>$this->parControl];
        return view('docentes.agregar',$mergeData);  
    }

    public function insertar(Request $request)
    {
        $request->validate([
          'id'=>'required',
          'codigo_docente'=>'required|max:30',
          'activo'=>'required',
        ]);
        $persona = Persona::find($request->id);
        $docente = new Docente();
        $docente->id = $request->id;
        $docente->login = $persona->ci;
        $docente->pass = md5($persona->ci) ;
        $docente->perfil_id = Docente::getIdPerfilDocente();
        $docente->codigo_docente = $request->codigo_docente;

        $docente->activo = $request->activo?true:false;
        $docente->save();

        return redirect()->route('docentes.mostrar',$request->id);
    }

    public function modificar($id)
    {
        $docente = Docente::find($id);

        $oPersona = new Persona();
        $nombrePersona = $oPersona->getNombreCompleto($id);

        $mergeData = ['id'=>$id,'docente'=>$docente,'nombreCompleto'=>$nombrePersona,'parControl'=>$this->parControl];
        return view('docentes.modificar',$mergeData);
    }

    public function actualizar(Request $request, Docente $Docente)
    {
        $request->validate([
            'codigo_docente'=>'required|max:30',
            'activo'=>'required',
        ]);
        $docente->codigo_docente = $request->codigo_docente;
        $docente->activo = $request->activo?true:false;
        $docente->save();

        return redirect()->route('docentes.mostrar',$docente->id);
    }

    public function eliminar($id)
    {
        $docente = Docente::find($id);
        $docente->eliminado=true;
        $docente->save();
        return redirect()->route('docente.index');
    }

    public function personasActivas(Request $request)
    {
        $buscar=$request->q;
        $docente = new Docente();
        $personas = $docente->buscarPersonas($buscar);
        $resultado=[];
        foreach ($personas as $persona){
            $resultado[]=(object)['name'=>$persona->nombre,'id'=>$persona->id];
        }
        return json_encode($resultado);
    }
}
