<?php
use App\Http\Controllers\HoraController;

Route::get('horas', [HoraController::class,'index'])->name('horas.index')->middleware('sesion.iniciada');
Route::get('horas/agregar', [HoraController::class,'agregar'])->name('horas.agregar')->middleware('sesion.iniciada');
Route::get('horas/{id}', [HoraController::class,'mostrar'])->name('horas.mostrar')->middleware('sesion.iniciada');
Route::post('horas', [HoraController::class,'insertar'])->name('horas.insertar')->middleware('sesion.iniciada');
Route::get('horas/{id}/modificar', [HoraController::class,'modificar'])->name('horas.modificar')->middleware('sesion.iniciada');
Route::put('horas/{hora}', [HoraController::class,'actualizar'])->name('horas.actualizar')->middleware('sesion.iniciada');
Route::delete('horas/{hora}', [HoraController::class,'eliminar'])->name('horas.eliminar')->middleware('sesion.iniciada');
