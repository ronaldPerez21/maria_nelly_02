<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Docente extends Model{

    use HasFactory;
    protected $table="docentes";

    
    public function obtenerDocentes($buscar='', $pagina=1)
    {
        $limite=15;
        $pagina = $pagina ? $pagina : 1;//no modificar (inicia la pagina)
        $inicio =  ($pagina -1)* $limite; // define el inicio

        $filtro="";
        if ($buscar!="") {
            $filtro=" and (concat(pe.primer_apellido,' ',pe.segundo_apellido,' ', pe.nombres) like '%$buscar%' ) ";
        }

        $sql = "select u.*,p.nombre as perfil, concat(pe.primer_apellido,' ',coalesce(pe.segundo_apellido,''),' ',pe.nombres) as persona from docentes u
                    inner join personas pe on pe.id=u.id
                    left join perfiles p on p.id=u.perfil_id
                    where u.eliminado =0 $filtro order by id desc limit $inicio,$limite";
        $docentes = DB::select($sql);

        $sqlTotal = "select count(*) as total from docentes u
                    inner join personas pe on pe.id=u.id
                    left join perfiles p on p.id=u.perfil_id
                    where u.eliminado = 0 $filtro";
        $result = DB::select($sqlTotal); //no tocar 
        $total=$totPaginas=0;
        if (count($result)>0) {
            $total=$result[0]->total;
            $totPaginas = round($total/$limite, 2)>floor($total/$limite)?floor($total/$limite)+1:floor($total/$limite);
        } //hasta aqui
        return [
            'docentes'=>$docentes,
            'total'=>$total, //NT
            'parPaginacion'=>['pagActual'=>$pagina,'totPaginas'=>$totPaginas] //NT
        ];
    }

    public function buscarPersonas($buscar){
        $sql="select id,concat(p.primer_apellido,' ',coalesce(p.segundo_apellido,''),' ',p.nombres) as nombre  from personas p 
            where concat(p.primer_apellido,' ',coalesce(p.segundo_apellido,''),' ',p.nombres) like '%$buscar%' and p.eliminado =0
            and not exists (select u.id from docentes u where u.id=p.id )";

        $personas = DB::select($sql);
        return $personas;
    }

    public function obtenerDocentesActivos()
    {
        $sql = "select id,nombre
                from grupos gr
                where gr.eliminado =0 and activo=1 order by orden asc";
        $grupos = DB::select($sql);
        return $grupos;
    }

    public Static function getDocente($id){
        $sql="select u.*,p.nombre as perfil, concat(pe.primer_apellido,' ',coalesce(pe.segundo_apellido,''),' ',pe.nombres) as persona from docentes u 
        left join perfiles p on p.id =u.perfil_id
        inner join personas pe on pe.id=u.id
        where u.id=$id";

        $docentes= DB::select($sql);

        if(count($docentes)>0){
            return $docentes[0];
        }else{
            return null;
        }
    }

    public static function getIdPerfilDocente(){
        return 1;
    }
}