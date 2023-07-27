<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Hora extends Model
{
    use HasFactory;
    protected $table="horas";

    public function obtenerHoras($buscar='', $pagina=1)
    {
        $limite=15;        
        $pagina = $pagina ? $pagina : 1;//no modificar (inicia la pagina)
        $inicio =  ($pagina -1)* $limite; // define el inicio

        $filtro="";
        if ($buscar!="") {
            $filtro=" and (h.hora_fin like '%$buscar%' or h.hora_ini like '%$buscar%') ";
        }

        $sql = "select * from horas h
                where h.eliminado = 0 $filtro order by id asc limit $inicio,$limite";
        $horas = DB::select($sql);

        $sqlTotal = "select count(*) as total from horas h
                    where h.eliminado = 0 $filtro";
        $result = DB::select($sqlTotal); //no tocar 
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        } //hasta aqui
        return [
            'horas'=>$horas,
            'total'=>$total, //NT
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas] //NT
        ];
    }
}
