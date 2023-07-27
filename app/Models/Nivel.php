<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Nivel extends Model
{
    use HasFactory;
    protected $table="niveles";

    public function obtenerNiveles($buscar='', $pagina=1)
    {
        $limite=15;        
        $pagina = $pagina ? $pagina : 1;//no modificar (inicia la pagina)
        $inicio =  ($pagina -1)* $limite; // define el inicio

        $filtro="";
        if ($buscar!="") {
            $filtro=" and (n.nombre like '%$buscar%' or n.numero like '%$buscar%') ";
        }

        $sql = "select * from niveles n
                where n.eliminado = 0 $filtro order by id desc limit $inicio,$limite";
        $niveles = DB::select($sql);

        $sqlTotal = "select count(*) as total from niveles n
                    where n.eliminado = 0 $filtro";
        $result = DB::select($sqlTotal); //no tocar 
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        } //hasta aqui
        return [
            'niveles'=>$niveles,
            'total'=>$total, //NT
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas] //NT
        ];
    }

    public function obtenerNivelesActivos()
    {
        $sql = "select id,nombre from niveles n where n.eliminado =0 and activo=1 order by nombre asc";
        $niveles = DB::select($sql);
        return $niveles;
    }
}
