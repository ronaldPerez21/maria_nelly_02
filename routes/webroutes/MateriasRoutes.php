<?php
use App\Http\Controllers\MateriaController;

Route::get('materias', [MateriaController::class,'index'])->name('materias.index')->middleware('sesion.iniciada');
Route::get('materias/agregar', [MateriaController::class,'agregar'])->name('materias.agregar')->middleware('sesion.iniciada');
Route::get('materias/{id}', [MateriaController::class,'mostrar'])->name('materias.mostrar')->middleware('sesion.iniciada');
Route::post('materias', [MateriaController::class,'insertar'])->name('materias.insertar')->middleware('sesion.iniciada');
Route::get('materias/{id}/modificar', [MateriaController::class,'modificar'])->name('materias.modificar')->middleware('sesion.iniciada');
Route::put('materias/{materia}', [MateriaController::class,'actualizar'])->name('materias.actualizar')->middleware('sesion.iniciada');
Route::delete('materias/{materia}', [MateriaController::class,'eliminar'])->name('materias.eliminar')->middleware('sesion.iniciada');
