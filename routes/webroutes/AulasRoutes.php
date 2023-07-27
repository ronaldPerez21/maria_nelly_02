<?php
use App\Http\Controllers\AulaController;

Route::get('aulas', [AulaController::class,'index'])->name('aulas.index')->middleware('sesion.iniciada');
Route::get('aulas/agregar', [AulaController::class,'agregar'])->name('aulas.agregar')->middleware('sesion.iniciada');
Route::get('aulas/{id}', [AulaController::class,'mostrar'])->name('aulas.mostrar')->middleware('sesion.iniciada');
Route::post('aulas', [AulaController::class,'insertar'])->name('aulas.insertar')->middleware('sesion.iniciada');
Route::get('aulas/{id}/modificar', [AulaController::class,'modificar'])->name('aulas.modificar')->middleware('sesion.iniciada');
Route::put('aulas/{aula}', [AulaController::class,'actualizar'])->name('aulas.actualizar')->middleware('sesion.iniciada');
Route::delete('aulas/{aula}', [AulaController::class,'eliminar'])->name('aulas.eliminar')->middleware('sesion.iniciada');
