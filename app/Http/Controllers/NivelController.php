<?php

namespace App\Http\Controllers;

use App\Models\Nivel;
use App\Libs\Funciones;
use Illuminate\Http\Request;

class NivelController extends Controller
{
    public $parControl=[
        'modulo'=>'academico',
        'funcionalidad'=>'niveles',
        'titulo' =>'Niveles',
        
    ];

    public function index(Request $request)
    {
        $nivel = new Nivel();
        $buscar=$request->buscar;
        $pagina=$request->pagina;
        $resultado = $nivel->obtenerNiveles($buscar,$pagina);
        $mergeData = [
            'niveles'=>$resultado['niveles'],
            'total'=>$resultado['total'],
            'buscar'=>$buscar,
            'parPaginacion'=>$resultado['parPaginacion'],
            'parControl'=>$this->parControl
        ];
        return view('niveles.index',$mergeData);
    }
    public function mostrar($id)
    {
        $nivel = Nivel::find($id);
        $mergeData = ['id'=>$id,'nivel'=>$nivel,'parControl'=>$this->parControl];
        return view('niveles.mostrar',$mergeData);
    }

    public function agregar()
    { 
        $mergeData = ['parControl'=>$this->parControl];
        return view('niveles.agregar',$mergeData);  
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'nombre'=>'required|max:30',
            'numero'=>'required|max:8',
            'activo'=>'required',
        ]);

        $nivel = new Nivel();
        $nivel->nombre = $request->nombre;
        $nivel->numero = $request->numero;
        $nivel->activo = $request->activo?true:false;
        $nivel->save();

        return redirect()->route('niveles.mostrar',$nivel->id);
    }

    public function modificar($id)
    {
        $nivel = Nivel::find($id);
        $mergeData = ['id'=>$id,'nivel'=>$nivel,'parControl'=>$this->parControl];
        return view('niveles.modificar',$mergeData);
    }

    public function actualizar(Request $request, Nivel $nivel)
    {
        $request->validate([
            'nombre'=>'required|max:30',
            'numero'=>'required|max:8',
            'activo'=>'required',
        ]);
        $nivel->nombre = $request->nombre;
        $nivel->numero = $request->numero;
        $nivel->activo = $request->activo?true:false;
        $nivel->save();

        return redirect()->route('niveles.mostrar',$nivel->id);
    }

    public function eliminar($id)
    {
        $nivel = Nivel::find($id);
        $nivel->eliminado=true;
        $nivel->save();
        return redirect()->route('niveles.index');
    }
}
