<?php
use App\Http\Controllers\DocenteController;
Route::get('docentes', [DocenteController::class,'index'])->name('docentes.index')->middleware('sesion.iniciada');
Route::get('docentes/agregar', [DocenteController::class,'agregar'])->name('docentes.agregar')->middleware('sesion.iniciada');
Route::get('docentes/{id}', [DocenteController::class,'mostrar'])->name('docentes.mostrar')->middleware('sesion.iniciada');
Route::post('docentes', [DocenteController::class,'insertar'])->name('docentes.insertar')->middleware('sesion.iniciada');
Route::get('docentes/{id}/modificar', [DocenteController::class,'modificar'])->name('docentes.modificar')->middleware('sesion.iniciada');
Route::put('docentes/{docente}', [DocenteController::class,'actualizar'])->name('docentes.actualizar')->middleware('sesion.iniciada');
Route::delete('docentes/{docente}', [DocenteController::class,'eliminar'])->name('docentes.eliminar')->middleware('sesion.iniciada');
Route::get('docentes/personas-activas/buscar', [DocenteController::class,'personasActivas'])->name('docentes.personasActivas')->middleware('sesion.iniciada');
