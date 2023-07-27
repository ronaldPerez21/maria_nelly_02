<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Grupo extends Model
{
    use HasFactory;
    protected $table="grupos";

    public function obtenerGrupos($buscar='', $pagina=1)
    {
        $limite=10;        
        $pagina = $pagina ? $pagina : 1;//no modificar (inicia la pagina)
        $inicio =  ($pagina -1)* $limite; // define el inicio

        $filtro="";
        if ($buscar!="") {
            $filtro=" and (gr.nombre like '%$buscar%' or t.nombre like '%$buscar%') ";
        }

        $sql = "select gr.*, g.anio as gestion , t.nombre as turno, gra.nombre as grado, a.nombre as aula
        from grupos gr
        inner join gestiones g on g.id =gr.gestion_id
        inner join turnos t on t.id =gr.turno_id  
        inner join grados gra on gra.id =gr.grado_id
        inner join aulas a on a.id =gr.aula_id
        where gr.eliminado =0 $filtro order by gr.id desc limit $inicio,$limite";

        $grupos = DB::select($sql);

        $sqlTotal = "select count(*) as total 
        from grupos gr
        inner join gestiones g on g.id =gr.gestion_id 
        inner join turnos t on t.id =gr.turno_id 
        inner join grados gra on gra.id =gr.grado_id
        inner join aulas a on a.id =gr.aula_id
        where gr.eliminado =0 $filtro ";

        $result = DB::select($sqlTotal); //no tocar 
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        } //hasta aqui
        return [
            'grupos'=>$grupos,
            'total'=>$total, //NT
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas] //NT
        ];
    }
    public function obtenerGruposActivos()
    {
        $sql = "select id,nombre
                from grupos gr
                where gr.eliminado =0 and gr.activo = 1 order by nombre asc";
        $grupos = DB::select($sql);
        return $grupos;
    }

    public static function getGrupo($id)
    {  
        $sql = "select gr.*, g.anio as gestion, t.nombre as turno, gra.nombre as grado, a.nombre as aula
                from grupos gr
                inner join gestiones g on g.id =gr.gestion_id 
                inner join turnos t on t.id =gr.turno_id
                inner join grados gra on gra.id =gr.grado_id
                inner join aulas a on a.id =gr.aula_id
                where gr.eliminado =0 and gr.id=$id";
        $grupos = DB::select($sql);
        if(count($grupos)>0){
            return $grupos[0];
        }else{
            return null;
        }
    }

    public static function ObtenerGruposValidos($grado_aprobado_id){
        $sqlSel = "select valor as campo from parametros p where p.nombre ='gestion_matricula'";
        $parametro = DB::select($sqlSel);
        $gestion_matricula = $parametro[0]->campo;
        $sqlSel = "select id,codigo from grupos where grado_id=$grado_aprobado_id and gestion_id=$gestion_matricula and eliminado=0";
        return DB::select($sqlSel);
    }
}
