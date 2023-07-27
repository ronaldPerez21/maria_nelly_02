<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mensualidad extends Model
{
    use HasFactory;
    protected $table="mensualidades";

    public function GenerarMensualidades($matricula_id){
        $sqlSel = "select valor as campo from parametros p where p.nombre ='mensualidades'";
        $parametro = DB::select($sqlSel);
        $mensualidades = $parametro[0]->campo;

        $sqlSel = "select valor as campo from parametros p where p.nombre ='dia_vencimiento'";
        $parametro = DB::select($sqlSel);
        $dia_vencimiento = $parametro[0]->campo;

        $sqlSel = "select valor as campo from parametros p where p.nombre ='gestion_matricula'";
        $parametro = DB::select($sqlSel);
        $gestion_matricula = $parametro[0]->campo;

        $sqlSel = "select valor as campo from parametros p where p.nombre ='monto_mensualidad'";
        $parametro = DB::select($sqlSel);
        $monto_mensualidad = $parametro[0]->campo;

        $sqlSel="select anio from gestiones where id=$gestion_matricula";
        $gestiones = DB::select($sqlSel);
        $anio = $gestiones[0]->anio;

        $meses = explode(',',$mensualidades);
        foreach ($meses as $mes){
            $mensualidad = new Mensualidad();
            $mes_sig=$mes+1;
            $mensualidad->fecha_vencimiento="$anio-$mes_sig-$dia_vencimiento";
            $mensualidad->mes=$mes;
            $mensualidad->monto=$monto_mensualidad;
            $mensualidad->matricula_id=$matricula_id;
            $mensualidad->pagado=false;
            $mensualidad->eliminado=false;
            $mensualidad->save();
        }
    }

    public function ObtenerMensualidades($matricula_id){
        $sqlSel = "select * from mensualidades where matricula_id=$matricula_id and eliminado=0";
        return DB::select($sqlSel);
    }
    public function ObtenerMensualidadesPagos($matricula_id){
        $sqlSel = "select m.*,p.id as pago_id from mensualidades m 
                    left join pagos p on p.mensualidad_id=m.id and p.anulado=0
                    where m.matricula_id=$matricula_id and m.eliminado =0";
        return DB::select($sqlSel);
    }
    public function InfoMensualidad($matricula_id){
        $sqlSel = "select concat(p.primer_apellido,' ',coalesce(p.segundo_apellido,''),' ',p.nombres) as estudiante,g.codigo
                     from matriculas m 
                    inner join personas p on m.estudiante_id=p.id
                    inner join grupos g on g.id=m.grupo_id
                    where m.id=$matricula_id and m.anulado =0";
        $infos = DB::select($sqlSel);
        return $infos[0];
    }
    public function ObtenerMensualidad($mensualidad_id){
        $sqlSel = "select concat(p.primer_apellido,' ',coalesce(p.segundo_apellido,''),' ',p.nombres) as estudiante,g.codigo as grupo 
                    ,me.fecha_vencimiento ,me.monto ,me.mes, me.matricula_id,me.id
                    from mensualidades me
                    inner join matriculas m on m.id=me.matricula_id 
                    inner join grupos g on g.id=m.grupo_id 
                    inner join personas p on p.id=m.estudiante_id
                    where me.id=$mensualidad_id and me.eliminado =0";
        $mensualidades=DB::select($sqlSel);
        return $mensualidades[0];
    }
}