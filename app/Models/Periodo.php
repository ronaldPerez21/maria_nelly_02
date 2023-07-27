<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Periodo extends Model
{
    use HasFactory;
    protected $table="periodos";

    public function obtenerPeriodos($buscar='', $pagina=1)
    {
        $limite=10;        
        $pagina = $pagina ? $pagina : 1;//no modificar (inicia la pagina)
        $inicio =  ($pagina -1)* $limite; // define el inicio

        $filtro="";
        if ($buscar!="") {
            $filtro=" and (p.fecha_inicio like '%$buscar%' or p.numero like '%$buscar%') ";
        }

        $sql = "select p.*, g.anio as gestion from periodos p
        inner join gestiones g on g.id =p.gestion_id 
        where p.eliminado =0 $filtro order by p.id desc limit $inicio,$limite";

        $periodos = DB::select($sql);

        $sqlTotal = "select count(*) as total from periodos p
        inner join gestiones g on g.id =p.gestion_id 
        where p.eliminado =0 $filtro ";

        $result = DB::select($sqlTotal); //no tocar 
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        } //hasta aqui
        return [
            'periodos'=>$periodos,
            'total'=>$total, //NT
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas] //NT
        ];
    }
    public static function getPeriodo($id)
    {  
        $sql = "select p.*, g.anio as gestion from periodos p
                inner join gestiones g on g.id =p.gestion_id 
                where p.eliminado =0 and p.id=$id";
        $periodos = DB::select($sql);
        if(count($periodos)>0){
            return $periodos[0];
        }else{
            return null;
        }
        
    }
}
