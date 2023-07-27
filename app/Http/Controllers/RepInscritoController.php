<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepInscritoController extends Controller
{
    public $parControl=[
        'modulo'=>'informes',
        'funcionalidad'=>'rep_inscritos',
        'titulo' =>'Rep. Inscritos',
    ];

    public function index(Request $request)
    {   
        $gestion_id=$request->gestion_id;
        $grupo_id=$request->grupo_id;
        $is_buscar=$request->is_buscar;
        $filtro = "";
        $sql = "select id,anio from gestiones where activo=1 and eliminado=0 order by anio desc";
        $gestiones = DB::select($sql);
        $grupos = [];
        if($gestion_id>0){
            $sql = "select id,codigo from grupos where gestion_id =$gestion_id;";
            $grupos = DB::select($sql);
        }
        if($grupo_id>0){
            $filtro = "and m.grupo_id=$grupo_id";
        }
        $resultados = [];
        if($is_buscar=='ok'){
            $sql = "select e.id, p.primer_apellido, p.segundo_apellido ,p.nombres,p.ci, p.ci_exp ,ge.anio, g.codigo, gra.nombre as grado
                    , m.created_at as fechaMatricula
                    from estudiantes e
                    inner join personas p on p.id=e.id
                    inner join matriculas m on m.estudiante_id =e.id
                    inner join grupos g on g.id =m.grupo_id
                    inner join grados gra on gra.id =g.grado_id 
                    inner join gestiones ge on ge.id=g.gestion_id
                    where  m.anulado=0 and g.gestion_id =$gestion_id $filtro
                    order by p.primer_apellido asc, p.segundo_apellido asc ,p.nombres asc";
            $resultados =DB::select($sql);
        }
        $mergeData = [
            'gestiones'=>$gestiones,
            'gestion_id'=>$gestion_id,
            'grupos'=>$grupos,
            'grupo_id'=>$grupo_id,
            'resultados'=>$resultados,
            'parPaginacion'=>[],
            'parControl'=>$this->parControl
        ];
        return view('RepInscritos.index',$mergeData);
    }

}
