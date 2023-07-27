<?php
use App\Http\Controllers\MensualidadController;
Route::get('mensualidades/validar-notas', [MensualidadController::class,'validarNotas'])->name('mensualidades.validarNotas')->middleware('sesion.iniciada');
Route::get('mensualidades/estudiantes-activos', [MensualidadController::class,'estudiantesActivos'])->name('mensualidades.estudiantesActivos')->middleware('sesion.iniciada');

Route::get('mensualidades', [MensualidadController::class,'index'])->name('mensualidades.index')->middleware('sesion.iniciada');
Route::get('mensualidades/listado/{matricula_id}', [MensualidadController::class,'mensualidades'])->name('mensualidades.listado')->middleware('sesion.iniciada');

Route::get('mensualidades/pagos/{mensualidad_id}', [MensualidadController::class,'pagar'])->name('mensualidades.pagar')->middleware('sesion.iniciada');
Route::post('mensualidades/pagos/{mensualidad_id}', [MensualidadController::class,'guardarPago'])->name('mensualidades.pagar')->middleware('sesion.iniciada');

Route::get('mensualidades/recibo/{id}', [MensualidadController::class,'recibo'])->name('mensualidades.recibo')->middleware('sesion.iniciada');



Route::delete('mensualidades/{matricula}', [MensualidadController::class,'anular'])->name('mensualidades.anular')->middleware('sesion.iniciada');
