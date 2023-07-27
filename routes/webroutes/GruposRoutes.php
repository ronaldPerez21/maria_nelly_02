<?php
use App\Http\Controllers\GrupoController;

Route::get('grupos', [GrupoController::class,'index'])->name('grupos.index')->middleware('sesion.iniciada');
Route::get('grupos/agregar', [GrupoController::class,'agregar'])->name('grupos.agregar')->middleware('sesion.iniciada');
Route::get('grupos/{id}', [GrupoController::class,'mostrar'])->name('grupos.mostrar')->middleware('sesion.iniciada');
Route::post('grupos', [GrupoController::class,'insertar'])->name('grupos.insertar')->middleware('sesion.iniciada');
Route::get('grupos/{id}/modificar', [GrupoController::class,'modificar'])->name('grupos.modificar')->middleware('sesion.iniciada');
Route::put('grupos/{grupo}', [GrupoController::class,'actualizar'])->name('grupos.actualizar')->middleware('sesion.iniciada');
Route::delete('grupos/{grupos}', [GrupoController::class,'eliminar'])->name('grupos.eliminar')->middleware('sesion.iniciada');
