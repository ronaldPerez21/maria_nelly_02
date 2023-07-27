<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Matricula extends Model
{
    use HasFactory;
    protected $table="matriculas";

    public function obtenerMatriculas($buscar='', $pagina=1)
    {
        $limite=30;        
        $pagina = $pagina ? $pagina : 1;//no modificar (inicia la pagina)
        $inicio =  ($pagina -1)* $limite; // define el inicio

        $filtro="";
        if ($buscar!="") {
            $filtro=" and (concat(pe.primer_apellido,' ',coalesce(pe.segundo_apellido,''),' ',pe.nombres) like '%$buscar%' or pe.ci like '%$buscar%') ";
        }

        $sql = "select m.*,concat(pe.primer_apellido,' ',coalesce(pe.segundo_apellido,''),' ',pe.nombres) as estudiante , g.nombre as grupo
        ,ge.anio as gestion
        from matriculas m
        inner join personas pe on pe.id =m.estudiante_id
        inner join grupos g on g.id =m.grupo_id  
        inner join gestiones ge on ge.id =g.gestion_id
        where m.anulado =0 $filtro order by m.id desc limit $inicio,$limite";

        $matriculas = DB::select($sql);

        $sqlTotal = "select count(*) as total 
        from matriculas m
        inner join personas pe on pe.id =m.estudiante_id
        inner join grupos g on g.id =m.grupo_id 
        inner join gestiones ge on ge.id =g.gestion_id
        where m.anulado =0 $filtro ";

        $result = DB::select($sqlTotal); //no tocar 
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        } //hasta aqui
        return [
            'matriculas'=>$matriculas,
            'total'=>$total, //NT
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas] //NT
        ];
    }

    public function obtenerMensualidadesMatriculas($buscar='', $pagina=1)
    {
        $limite=30;        
        $pagina = $pagina ? $pagina : 1;//no modificar (inicia la pagina)
        $inicio =  ($pagina -1)* $limite; // define el inicio

        $matriculas=[];
        $total=0;
        $pagina=0;
        $totPaginas=0;

        if($buscar){

            $sqlSel = "select valor as campo from parametros p where p.nombre ='gestion_matricula'";
            $parametro = DB::select($sqlSel);
            $gestion_matricula = $parametro[0]->campo;

            $filtro="";
            if ($buscar!="") {
                $filtro=" and (concat(pe.primer_apellido,' ',coalesce(pe.segundo_apellido,''),' ',pe.nombres) like '%$buscar%' or pe.ci like '%$buscar%') ";
            }
            $filtro .=" and g.gestion_id=$gestion_matricula ";

            $sql = "select m.*,concat(pe.primer_apellido,' ',coalesce(pe.segundo_apellido,''),' ',pe.nombres) as estudiante , g.nombre as grupo
            ,ge.anio as gestion
            from matriculas m
            inner join personas pe on pe.id =m.estudiante_id
            inner join grupos g on g.id =m.grupo_id  
            inner join gestiones ge on ge.id =g.gestion_id
            where m.anulado =0 $filtro order by pe.primer_apellido desc, pe.segundo_apellido desc, pe.nombres desc limit $inicio,$limite";

            
            $matriculas = DB::select($sql);

            $sqlTotal = "select count(*) as total 
            from matriculas m
            inner join personas pe on pe.id =m.estudiante_id
            inner join grupos g on g.id =m.grupo_id 
            inner join gestiones ge on ge.id =g.gestion_id
            where m.anulado =0 $filtro ";

            $result = DB::select($sqlTotal); //no tocar 
            $total=$totPaginas=0;
            if (count($result)>0) {
                $total=$result[0]->total;
                $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
            } //hasta aqui
        }

        return [
            'matriculas'=>$matriculas,
            'total'=>$total, //NT
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas] //NT
        ];
    }
    public static function getMatricula($id)
    {  
        $sql ="select m.*,concat(pe.primer_apellido,' ',coalesce(pe.segundo_apellido,''),' ',pe.nombres) as estudiante , gr.nombre as grupo
                from matriculas m
                inner join personas pe on pe.id =m.estudiante_id
                inner join grupos gr on gr.id =m.grupo_id 
                where m.anulado =0 and m.id=$id";
        $matriculas = DB::select($sql);
        if(count($matriculas)>0){
            return $matriculas[0];
        }else{
            return null;
        }
        
    }

    public function buscarPersonas($buscar){
        $sql="select id,concat(p.primer_apellido,' ',coalesce(p.segundo_apellido,''),' ',p.nombres) as nombre  
            from personas p 
            where concat(p.primer_apellido,' ',coalesce(p.segundo_apellido,''),' ',p.nombres) like '%$buscar%' and p.eliminado =0
            and not exists (select u.id from usuarios u where u.id=p.id )";

        $personas = DB::select($sql);
        return $personas;
    }
}
