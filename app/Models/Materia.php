<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Materia extends Model
{
    use HasFactory;
    protected $table="materias";

    public function obtenerMaterias($buscar='', $pagina=1)
    {
        $limite=15;
        $pagina = $pagina ? $pagina : 1;//no modificar (inicia la pagina)
        $inicio =  ($pagina -1)* $limite; // define el inicio

        $filtro="";
        if ($buscar!="") {
            $filtro=" and (m.nombre like '%$buscar%' ) ";
        }

        $sql = "select m.*, ac.nombre as area_conocimiento from materias m
                    inner join areas_conocimientos ac on ac.id =m.area_conocimiento_id 
                    where m.eliminado =0 $filtro order by m.id desc limit $inicio,$limite";
        $materias = DB::select($sql);
        $sqlTotal = "select count(*) as total from materias m
                    inner join areas_conocimientos ac on ac.id =m.area_conocimiento_id 
                    where m.eliminado =0 $filtro ";
        $result = DB::select($sqlTotal); //no tocar 
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        } //hasta aqui
        return [
            'materias'=>$materias,
            'total'=>$total, //NT
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas] //NT
        ];
    }

    public static function getMateria($id)
    {  
        $sql = "select m.*, ac.nombre as area_conocimiento from materias m
                    inner join areas_conocimientos ac on ac.id =m.area_conocimiento_id 
                    where m.eliminado =0 and m.id=$id";
        $materias = DB::select($sql);
        if(count($materias)>0){
            return $materias[0];
        }else{
            return null;
        }
        
    }
}
