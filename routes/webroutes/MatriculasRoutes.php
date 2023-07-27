<?php
use App\Http\Controllers\MatriculaController;
Route::get('matriculas/validar-notas', [MatriculaController::class,'validarNotas'])->name('matriculas.validarNotas')->middleware('sesion.iniciada');
Route::get('matriculas/estudiantes-activos', [MatriculaController::class,'estudiantesActivos'])->name('matriculas.estudiantesActivos')->middleware('sesion.iniciada');
Route::get('matriculas', [MatriculaController::class,'index'])->name('matriculas.index')->middleware('sesion.iniciada');
Route::get('matriculas/agregar', [MatriculaController::class,'agregar'])->name('matriculas.agregar')->middleware('sesion.iniciada');
Route::get('matriculas/{id}', [MatriculaController::class,'mostrar'])->name('matriculas.mostrar')->middleware('sesion.iniciada');

Route::post('matriculas', [MatriculaController::class,'insertar'])->name('matriculas.insertar')->middleware('sesion.iniciada');
Route::delete('matriculas/{matricula}', [MatriculaController::class,'anular'])->name('matriculas.anular')->middleware('sesion.iniciada');
