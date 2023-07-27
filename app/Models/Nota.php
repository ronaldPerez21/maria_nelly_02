<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Nota extends Model
{
    use HasFactory;
    protected $table="niveles";

    function ValidarNotasEstudiante($estudiante_id){
        $sqlSel = "select valor as campo from parametros p where p.nombre ='gestion_notas'";
        $parametro = DB::select($sqlSel);
        $gestion_notas = $parametro[0]->campo;
        $sqlSel = "select n.matricula_id, e.id,  gra.nombre as grado, gra.numero 
                    ,mat.id as materia_id
                    ,count(*) as cantidad,avg(valor) as promedio
                    from estudiantes e
                    inner join personas p on p.id=e.id
                    inner join matriculas m on m.estudiante_id =e.id
                    inner join grupos g on g.id =m.grupo_id
                    inner join grados gra on gra.id =g.grado_id 
                    inner join gestiones ge on ge.id=g.gestion_id
                    inner join notas n on n.matricula_id =m.id
                    inner join grupos_materias gm on gm.id=n.grupo_materia_id
                    inner join materias mat on mat.id=gm.materia_id
                    where  m.anulado=0 and g.gestion_id=$gestion_notas and e.id=$estudiante_id
                    group by n.matricula_id,e.id, gra.nombre, mat.id
                    order by p.primer_apellido asc, p.segundo_apellido asc ,p.nombres asc, n.matricula_id asc ,mat.nombre asc";
        $notas =DB::select($sqlSel);
        $num_materias=0;
        $num_materias_ok=0;
        $num_materias_nook=0;
        $sum_promedio =0;
        $num_grado_actual=0;
        foreach($notas as $fila){
            $sum_promedio += $fila->promedio;
            $num_materias ++;
            if($fila->promedio>=51){
                $num_materias_ok++;
            }else{
                $num_materias_nook++;
            }
            $num_grado_actual=$fila->numero;
        }
        $num_grado_matricular=0;
        if($num_materias_nook>0){
            $num_grado_matricular=$num_grado_actual;
        }else{
            $num_grado_matricular=$num_grado_actual+1;
        }

        $sqlSel = "select id,nombre from grados g where eliminado =0 and numero =$num_grado_matricular";
        $grados =DB::select($sqlSel);
        if(count($grados)>0){
            $grado = $grados[0];
            return $grado->id;
        }else{
            return 0;
        }

    }
}
