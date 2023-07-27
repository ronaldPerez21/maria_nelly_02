<?php

namespace App\Http\Controllers;
use App\Models\Periodo;
use App\Models\Gestion;
use App\Libs\Funciones;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    public $parControl=[
        'modulo'=>'academico',
        'funcionalidad'=>'periodos',
        'titulo' =>'Periodos',
    ];

    public function index(Request $request)
    {
        $periodo = new Periodo();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $periodo->obtenerPeriodos($buscar,$pagina);
        $mergeData = [
            'periodos'=>$resultado['periodos'],
            'total'=>$resultado['total'],
            'buscar'=>$buscar,
            'parPaginacion'=>$resultado['parPaginacion'],
            'parControl'=>$this->parControl
        ];
        return view('periodos.index',$mergeData);
    }
    public function mostrar($id)
    {
        $periodo = Periodo::getPeriodo($id);
        $mergeData = ['id'=>$id,'periodo'=>$periodo,'parControl'=>$this->parControl];
        return view('periodos.mostrar',$mergeData);
    }

    public function agregar()
    { 
        $gestion= new Gestion();
        $gestiones = $gestion->obtenerGestionesActivos();

        $mergeData = ['parControl'=>$this->parControl,'gestiones'=>$gestiones];
        return view('periodos.agregar',$mergeData);  
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'fecha_inicio'=>'required|max:30',
            'fecha_fin'=>'required|max:30',
            'numero'=>'required|max:30',
            'gestion_id'=>'required',
            'activo'=>'required',
        ]);

        $periodo = new Periodo();
        $periodo->fecha_inicio = $request->fecha_inicio;
        $periodo->fecha_fin = $request->fecha_fin;
        $periodo->numero = $request->numero;
        $periodo->gestion_id = $request->gestion_id;
        $periodo->activo = $request->activo?true:false;
        $periodo->save();

        return redirect()->route('periodos.mostrar',$periodo->id);
    }

    public function modificar($id)
    {
        $periodo = Periodo::find($id);
        $gestion = new Gestion();
        $gestiones = $gestion->obtenerGestionesActivos();
        $mergeData = ['id'=>$id,'periodo'=>$periodo,'gestiones'=>$gestiones,
                    'parControl'=>$this->parControl];
        return view('periodos.modificar',$mergeData);
    }

    public function actualizar(Request $request, Periodo $periodo)
    {
        $request->validate([
            'fecha_inicio'=>'required|max:30',
            'fecha_fin'=>'required|max:30',
            'numero'=>'required|max:30',
            'gestion_id'=>'required',
            'activo'=>'required',
        ]);
        $periodo->fecha_inicio = $request->fecha_inicio;
        $periodo->fecha_fin = $request->fecha_fin;
        $periodo->numero = $request->numero;
        $periodo->gestion_id = $request->gestion_id;
        $periodo->activo = $request->activo?true:false;
        $periodo->save();

        return redirect()->route('periodos.mostrar',$periodo->id);
    }

    public function eliminar($id)
    {
        $periodo = Periodo::find($id);
        $periodo->eliminado=true;
        $periodo->save();
        return redirect()->route('periodos.index');
    }
}
