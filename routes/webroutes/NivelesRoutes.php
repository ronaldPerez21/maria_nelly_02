<?php
use App\Http\Controllers\NivelController;

Route::get('niveles', [NivelController::class,'index'])->name('niveles.index')->middleware('sesion.iniciada');
Route::get('niveles/agregar', [NivelController::class,'agregar'])->name('niveles.agregar')->middleware('sesion.iniciada');
Route::get('niveles/{id}', [NivelController::class,'mostrar'])->name('niveles.mostrar')->middleware('sesion.iniciada');
Route::post('niveles', [NivelController::class,'insertar'])->name('niveles.insertar')->middleware('sesion.iniciada');
Route::get('niveles/{id}/modificar', [NivelController::class,'modificar'])->name('niveles.modificar')->middleware('sesion.iniciada');
Route::put('niveles/{nivel}', [NivelController::class,'actualizar'])->name('niveles.actualizar')->middleware('sesion.iniciada');
Route::delete('niveles/{nivel}', [NivelController::class,'eliminar'])->name('niveles.eliminar')->middleware('sesion.iniciada');
