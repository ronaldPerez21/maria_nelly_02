<?php

namespace App\Http\Controllers;
use App\Models\Gestion;
use App\Libs\Funciones;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GestionController extends Controller
{
    public $parControl=[
        'modulo'=>'academico',
        'funcionalidad'=>'gestiones',
        'titulo' =>'Gestiones',
    ];

    public function index(Request $request)
    {
        $gestion = new Gestion();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $gestion->obtenerGestiones($buscar,$pagina);
        $mergeData = [
            'gestiones'=>$resultado['gestiones'],
            'total'=>$resultado['total'],
            'buscar'=>$buscar,
            'parPaginacion'=>$resultado['parPaginacion'],
            'parControl'=>$this->parControl
        ];
        return view('gestiones.index',$mergeData);
    }
    public function mostrar($id)
    {
        $gestion = Gestion::find($id);
        $mergeData = ['id'=>$id,'gestion'=>$gestion,'parControl'=>$this->parControl];
        return view('gestiones.mostrar',$mergeData);
    }

    public function agregar()
    { 
        $mergeData = ['parControl'=>$this->parControl];
        return view('gestiones.agregar',$mergeData);  
    }

    public function insertar(Request $request)
    {
        $request->validate([

            'anio'=>'required|max:30',
            'fecha_inicio_clases'=>'required|max:30',
            'fecha_final_clases'=>'required|max:30',
            'numeros_periodos'=>'required|max:30',
            'tipos_periodos'=>'required|max:30',
            'activo'=>'required',
        ]);

        $gestion = new Gestion();
        $gestion->anio = $request->anio;
        $gestion->fecha_inicio_clases = $request->fecha_inicio_clases;
        $gestion->fecha_final_clases = $request->fecha_final_clases;
        $gestion->numeros_periodos = $request->numeros_periodos;
        $gestion->tipos_periodos = $request->tipos_periodos;
        $gestion->activo = $request->activo?true:false;
        $gestion->save();

        return redirect()->route('gestiones.mostrar',$gestion->id);
    }

    public function modificar($id)
    {
        $gestion = Gestion::find($id);
        $mergeData = ['id'=>$id,'gestion'=>$gestion,'parControl'=>$this->parControl];
        return view('gestiones.modificar',$mergeData);
    }

    public function actualizar(Request $request, Gestion $gestion)
    {
        $request->validate([
            'anio'=>'required|max:30',
            'fecha_inicio_clases'=>'required|max:30',
            'fecha_final_clases'=>'required|max:30',
            'numeros_periodos'=>'required|max:30',
            'tipos_periodos'=>'required|max:30',
            'activo'=>'required',
        ]);
        $gestion->anio = $request->anio;
        $gestion->fecha_inicio_clases = $request->fecha_inicio_clases;
        $gestion->fecha_final_clases = $request->fecha_final_clases;
        $gestion->numeros_periodos = $request->numeros_periodos;
        $gestion->tipos_periodos = $request->tipos_periodos;
        $gestion->activo = $request->activo?true:false;
        $gestion->save();

        return redirect()->route('gestiones.mostrar',$gestion->id);
    }

    public function eliminar($id)
    {
        $gestion = Gestion::find($id);
        $gestion->eliminado=true;
        $gestion->save();
        return redirect()->route('gestiones.index');
    }
}
