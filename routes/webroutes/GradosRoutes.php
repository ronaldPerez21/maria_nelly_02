<?php
use App\Http\Controllers\GradoController;

Route::get('grados', [GradoController::class,'index'])->name('grados.index')->middleware('sesion.iniciada');
Route::get('grados/agregar', [GradoController::class,'agregar'])->name('grados.agregar')->middleware('sesion.iniciada');
Route::get('grados/{id}', [GradoController::class,'mostrar'])->name('grados.mostrar')->middleware('sesion.iniciada');
Route::post('grados', [GradoController::class,'insertar'])->name('grados.insertar')->middleware('sesion.iniciada');
Route::get('grados/{id}/modificar', [GradoController::class,'modificar'])->name('grados.modificar')->middleware('sesion.iniciada');
Route::put('grados/{grado}', [GradoController::class,'actualizar'])->name('grados.actualizar')->middleware('sesion.iniciada');
Route::delete('grados/{grado}', [GradoController::class,'eliminar'])->name('grados.eliminar')->middleware('sesion.iniciada');
