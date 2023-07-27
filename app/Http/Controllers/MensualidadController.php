<?php

namespace App\Http\Controllers;
use App\Models\Matricula;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Models\Nota;
use App\Models\Gestion;
use App\Models\Pago;
use App\Models\Mensualidad;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MensualidadController extends Controller
{
    public $parControl=[
        'modulo'=>'inscripcion',
        'funcionalidad'=>'mensualidades',
        'titulo' =>'Mensualidades',
    ];

    public function index(Request $request){
        $matricula = new Matricula();
        $buscar=$request->buscar;
        $pagina=$request->pagina;

        $sqlSel = "select valor as campo from parametros p where p.nombre ='gestion_matricula'";
        $parametro = DB::select($sqlSel);
        $gestion_matricula = $parametro[0]->campo;
        $gestion = Gestion::find($gestion_matricula);
        
        $resultado = $matricula->obtenerMensualidadesMatriculas($buscar,$pagina);
        $mergeData = [
            'matriculas'=>$resultado['matriculas'],
            'total'=>$resultado['total'],
            'buscar'=>$buscar,
            'parPaginacion'=>$resultado['parPaginacion'],
            'parControl'=>$this->parControl,
            'gestion'=>$gestion
        ];
        return view('mensualidades.index',$mergeData);
    }
    public function mensualidades($matricula_id){
        $mensualidad = new Mensualidad();
        $mensualidades = $mensualidad->ObtenerMensualidadesPagos($matricula_id);
        $info = $mensualidad->InfoMensualidad($matricula_id);

        $mergeData = [
            'mensualidades'=>$mensualidades,
            'info'=>$info,
            'parControl'=>$this->parControl
        ];
        return view('mensualidades.listado',$mergeData);
    }

    public function pagar($mensualidad_id){
        $mensualidad = new Mensualidad();
        $_mensualidad = $mensualidad->ObtenerMensualidad($mensualidad_id);
        $mergeData = [
            'mensualidad'=>$_mensualidad,
            'parControl'=>$this->parControl
        ];
        return view('mensualidades.pagar',$mergeData);
    }

    public function guardarPago(Request $request,$mensualidad_id){
        $pago = new Pago();
        $mensualidad = Mensualidad::find($mensualidad_id);
        $pago->fecha = date('Y-m-d');
        $pago->monto = $mensualidad->monto;
        $pago->mensualidad_id = $mensualidad_id;
        $pago->observacion = $request->observacion;
        $pago->anulado = false;
        $pago->save();

        $mensualidad->pagado=true;
        $mensualidad->save();
        
        return redirect()->route('mensualidades.recibo',$pago->id);
    }

    public function recibo($pago_id){
        
        $pago = new Pago();
        $_pago = $pago->ObtenerPago($pago_id);
        $mergeData = [
            'pago'=>$_pago,
            'parControl'=>$this->parControl
        ];
        return view('mensualidades.recibo',$mergeData);
    }
}
