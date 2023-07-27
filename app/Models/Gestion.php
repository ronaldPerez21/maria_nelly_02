<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gestion extends Model
{
    use HasFactory;
    protected $table="gestiones";

    public function obtenerGestiones($buscar='', $pagina=1)
    {
        $limite=10;        
        $pagina = $pagina ? $pagina : 1;//no modificar (inicia la pagina)
        $inicio =  ($pagina -1)* $limite; // define el inicio

        $filtro="";
        if ($buscar!="") {
            $filtro=" and (g.anio like '%$buscar%' or g.fecha_inicio_clases like '%$buscar%'or g.fecha_final_clases like '%$buscar%'or g.numeros_periodos like '%$buscar%'or g.tipos_periodos like '%$buscar%') ";
        }

        $sql = "select * from gestiones g
                where g.eliminado = 0 $filtro order by id desc limit $inicio,$limite";
        $gestiones = DB::select($sql);

        $sqlTotal = "select count(*) as total from gestiones g
                    where g.eliminado = 0 $filtro";
        $result = DB::select($sqlTotal); //no tocar 
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        } //hasta aqui
        return [
            'gestiones'=>$gestiones,
            'total'=>$total, //NT
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas] //NT
        ];
    }

    public function obtenerGestionesActivos()
    {
        $sql = "select id,anio from gestiones g where g.eliminado =0 and activo=1 order by anio asc";
        $gestiones = DB::select($sql);
        return $gestiones;
    }
}
