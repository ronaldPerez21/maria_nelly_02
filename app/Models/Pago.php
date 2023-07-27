<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Pago extends Model
{
    use HasFactory;
    protected $table="pagos";
    function ObtenerPago($pago_id){
        $sqlSel = "select concat(p.primer_apellido,' ',coalesce(p.segundo_apellido,''),' ',p.nombres) as estudiante,g.codigo as grupo 
                    ,me.fecha_vencimiento ,me.monto ,me.mes, me.matricula_id,me.id, pag.fecha, pag.observacion
                    from pagos pag
                    inner join mensualidades me on me.id=pag.mensualidad_id
                    inner join matriculas m on m.id=me.matricula_id 
                    inner join grupos g on g.id=m.grupo_id 
                    inner join personas p on p.id=m.estudiante_id
                    where pag.id=$pago_id and me.eliminado =0";
        $pagos=DB::select($sqlSel);
        return $pagos[0];
        
    }
}
