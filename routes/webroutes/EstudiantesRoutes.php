<?php
use App\Http\Controllers\EstudianteController;
Route::get('estudiantes', [EstudianteController::class,'index'])->name('estudiantes.index')->middleware('sesion.iniciada');
Route::get('estudiantes/agregar', [EstudianteController::class,'agregar'])->name('estudiantes.agregar')->middleware('sesion.iniciada');
Route::get('estudiantes/{id}', [EstudianteController::class,'mostrar'])->name('estudiantes.mostrar')->middleware('sesion.iniciada');
Route::post('estudiantes', [EstudianteController::class,'insertar'])->name('estudiantes.insertar')->middleware('sesion.iniciada');
Route::get('estudiantes/{id}/modificar', [EstudianteController::class,'modificar'])->name('estudiantes.modificar')->middleware('sesion.iniciada');
Route::put('estudiantes/{estudiante}', [EstudianteController::class,'actualizar'])->name('estudiantes.actualizar')->middleware('sesion.iniciada');
Route::delete('estudiantes/{estudiante}', [EstudianteController::class,'eliminar'])->name('estudiantes.eliminar')->middleware('sesion.iniciada');
Route::get('estudiantes/personas-activas/buscar', [EstudianteController::class,'personasActivas'])->name('estudiantes.personasActivas')->middleware('sesion.iniciada');
