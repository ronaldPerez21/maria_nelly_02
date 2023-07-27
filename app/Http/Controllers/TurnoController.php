<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use App\Libs\Funciones;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    public $parControl=[
        'modulo'=>'academico',
        'funcionalidad'=>'turnos',
        'titulo' =>'Turnos',
    ];

    public function index(Request $request)
    {
        $turno = new Turno();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $turno->obtenerTurnos($buscar,$pagina);
        $mergeData = [
            'turnos'=>$resultado['turnos'],
            'total'=>$resultado['total'],
            'buscar'=>$buscar,
            'parPaginacion'=>$resultado['parPaginacion'],
            'parControl'=>$this->parControl
        ];
        return view('turnos.index',$mergeData);
    }
    public function mostrar($id)
    {
        $turno = Turno::find($id);
        $mergeData = ['id'=>$id,'turno'=>$turno,'parControl'=>$this->parControl];
        return view('turnos.mostrar',$mergeData);
    }

    public function agregar()
    { 
        $mergeData = ['parControl'=>$this->parControl];
        return view('turnos.agregar',$mergeData);  
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'nombre'=>'required|max:30',
            'hora_ini'=>'required|max:8',
            'hora_fin'=>'required|max:8',
            'activo'=>'required',
        ]);

        $turno = new Turno();
        $turno->nombre = $request->nombre;
        $turno->hora_ini = $request->hora_ini;
        $turno->hora_fin = $request->hora_fin;
        $turno->activo = $request->activo?true:false;
        $turno->save();

        return redirect()->route('turnos.mostrar',$turno->id);
    }

    public function modificar($id)
    {
        $turno = Turno::find($id);
        $mergeData = ['id'=>$id,'turno'=>$turno,'parControl'=>$this->parControl];
        return view('turnos.modificar',$mergeData);
    }

    public function actualizar(Request $request, Turno $turno)
    {
        $request->validate([
            'nombre'=>'required|max:30',
            'hora_ini'=>'required|max:8',
            'hora_fin'=>'required|max:8',
            'activo'=>'required',
        ]);
        $turno->nombre = $request->nombre;
        $turno->hora_ini = $request->hora_ini;
        $turno->hora_fin = $request->hora_fin;
        $turno->activo = $request->activo?true:false;
        $turno->save();

        return redirect()->route('turnos.mostrar',$turno->id);
    }

    public function eliminar($id)
    {
        $turno = Turno::find($id);
        $turno->eliminado=true;
        $turno->save();
        return redirect()->route('turnos.index');
    }
}
