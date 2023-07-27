<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepNotaController extends Controller
{
    
    public $parControl=[
        'modulo'=>'informes',
        'funcionalidad'=>'rep_notas',
        'titulo' =>'Rep. de Notas ',
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
        $notas = [];
        if($is_buscar=='ok'){
            $sql = "select n.matricula_id, e.id, p.primer_apellido, p.segundo_apellido ,p.nombres,p.ci, p.ci_exp ,ge.anio, g.codigo, gra.nombre as grado
                    ,mat.id as materia_id,mat.nombre as materia
                    ,count(*) as cantidad,avg(valor) as promedio
                    from estudiantes e
                    inner join personas p on p.id=e.id
                    inner join matriculas m on m.estudiante_id =e.id
                    inner join grupos g on g.id =m.grupo_id
                    inner join grados gra on gra.id =g.grado_id 
                    inner join gestiones ge on ge.id=g.gestion_id
                    inner join notas n on n.matricula_id =m.id
                    inner join grupos_materias gm on gm.id=n.grupo_materia_id
                    inner join materias mat on mat.id=gm.materia_id
                    where  m.anulado=0 and g.gestion_id =$gestion_id $filtro
                    group by n.matricula_id,e.id, p.primer_apellido, p.segundo_apellido ,p.nombres,p.ci, p.ci_exp ,ge.anio, g.codigo, gra.nombre, mat.id, mat.nombre 
                    order by p.primer_apellido asc, p.segundo_apellido asc ,p.nombres asc, n.matricula_id asc ,mat.nombre asc";
            $notas =DB::select($sql);
        }
        $resultados = [];
        foreach($notas as $fila){
            $_nota = $this->ObtenerFilaMaticula($resultados,$fila->matricula_id);
            if($_nota==null){
                $num_mat_ok = $fila->promedio>=51?1:0;
                $num_mat_nook = $fila->promedio<51?1:0;
                $_nota  = (object) [
                    'matricula_id'=>$fila->matricula_id,
                    'estudiante_id'=>$fila->id,
                    'estudiante'=>"$fila->primer_apellido $fila->segundo_apellido $fila->nombres",
                    'ci'=>"$fila->ci",
                    'ci_exp'=>"$fila->ci_exp",
                    'anio'=>$fila->anio,
                    'codigo'=>$fila->codigo,
                    'grado'=>$fila->grado,
                    'promedio'=>$fila->promedio,
                    'num_materias'=>1,
                    'num_materias_ok'=>$num_mat_ok,
                    'num_materias_nook'=>$num_mat_nook,

                ];
                $resultados[]=$_nota;
            }else{
                $_nota->promedio += $fila->promedio;
                $_nota->num_materias ++;
                if($fila->promedio>=51){
                    $_nota->num_materias_ok++;
                }else{
                    $_nota->num_materias_nook++;
                }
            }
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
        return view('RepNotas.index',$mergeData);
    }

    public function ObtenerFilaMaticula($resultados, $matricula_id){
        foreach($resultados as $nota){
            if($matricula_id==$nota->matricula_id){
                return $nota;
            }
        }
        return null;
    }
}
