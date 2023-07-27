<?php
use App\Http\Controllers\TurnoController;

Route::get('turnos', [TurnoController::class,'index'])->name('turnos.index')->middleware('sesion.iniciada');
Route::get('turnos/agregar', [TurnoController::class,'agregar'])->name('turnos.agregar')->middleware('sesion.iniciada');
Route::get('turnos/{id}', [TurnoController::class,'mostrar'])->name('turnos.mostrar')->middleware('sesion.iniciada');
Route::post('turnos', [TurnoController::class,'insertar'])->name('turnos.insertar')->middleware('sesion.iniciada');
Route::get('turnos/{id}/modificar', [TurnoController::class,'modificar'])->name('turnos.modificar')->middleware('sesion.iniciada');
Route::put('turnos/{turno}', [TurnoController::class,'actualizar'])->name('turnos.actualizar')->middleware('sesion.iniciada');
Route::delete('turnos/{turno}', [TurnoController::class,'eliminar'])->name('turnos.eliminar')->middleware('sesion.iniciada');
