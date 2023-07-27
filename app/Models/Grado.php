<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Grado extends Model
{
    use HasFactory;
    protected $table="grados";

    public function obtenerGrados($buscar='', $pagina=1)
    {
        $limite=15;
        $pagina = $pagina ? $pagina : 1;//no modificar (inicia la pagina)
        $inicio =  ($pagina -1)* $limite; // define el inicio

        $filtro="";
        if ($buscar!="") {
            $filtro=" and (g.nombre like '%$buscar%' ) ";
        }

        $sql = "select g.*, n.nombre as nivel from grados g
                    inner join niveles n on n.id =g.nivel_id 
                    where g.eliminado =0 $filtro order by g.id desc limit $inicio,$limite";
        $grados = DB::select($sql);
        $sqlTotal = "select count(*) as total from grados g
                    inner join niveles n on n.id =g.nivel_id 
                    where g.eliminado =0 $filtro ";
        $result = DB::select($sqlTotal); //no tocar 
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        } //hasta aqui
        return [
            'grados'=>$grados,
            'total'=>$total, //NT
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas] //NT
        ];
    }

    public function obtenerGradosActivos()
    {
        $sql = "select id,nombre 
                from grados gr 
                where gr.eliminado =0 and activo=1 order by nombre asc";
        $grados = DB::select($sql);
        return $grados;
    }

    public static function getGrado($id)
    {  
        $sql = "select g.*, n.nombre as nivel from grados g
                    inner join niveles n on n.id =g.nivel_id 
                    where g.eliminado =0 and g.id=$id";
        $grados = DB::select($sql);
        if(count($grados)>0){
            return $grados[0];
        }else{
            return null;
        }
        
    }
}
