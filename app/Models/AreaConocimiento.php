<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AreaConocimiento extends Model
{
    use HasFactory;
    protected $table="areas_conocimientos";
    public function obtenerAreaConocimientos($buscar='', $pagina=1)
    {
        $limite=15;
        $pagina = $pagina ? $pagina : 1;//no modificar (inicia la pagina)
        $inicio =  ($pagina -1)* $limite; // define el inicio

        $filtro="";
        if ($buscar!="") {
            $filtro=" and (a.nombre like '%$buscar%' ) ";
        }

        $sql = "select * from areas_conocimientos a
                    where a.eliminado =0 $filtro order by id desc limit $inicio,$limite";
        $areas_conocimientos = DB::select($sql);

        $sqlTotal = "select count(*) as total from areas_conocimientos a
                    where a.eliminado = 0 $filtro";
        $result = DB::select($sqlTotal); //no tocar 
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        } //hasta aqui
        return [
            'areas_conocimientos'=>$areas_conocimientos,
            'total'=>$total, //NT
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas] //NT
        ];
    }

    public function obtenerAreasConocimientosActivos()
    {
        $sql = "select id,nombre from areas_conocimientos a where a.eliminado =0 and activo=1 order by nombre asc";
        $areas_conocimientos = DB::select($sql);
        return $areas_conocimientos;
    }
}
