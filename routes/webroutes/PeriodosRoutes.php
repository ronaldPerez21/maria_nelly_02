<?php
use App\Http\Controllers\PeriodoController;

Route::get('periodos', [PeriodoController::class,'index'])->name('periodos.index')->middleware('sesion.iniciada');
Route::get('periodos/agregar', [PeriodoController::class,'agregar'])->name('periodos.agregar')->middleware('sesion.iniciada');
Route::get('periodos/{id}', [PeriodoController::class,'mostrar'])->name('periodos.mostrar')->middleware('sesion.iniciada');
Route::post('periodos', [PeriodoController::class,'insertar'])->name('periodos.insertar')->middleware('sesion.iniciada');
Route::get('periodos/{id}/modificar', [PeriodoController::class,'modificar'])->name('periodos.modificar')->middleware('sesion.iniciada');
Route::put('periodos/{periodo}', [PeriodoController::class,'actualizar'])->name('periodos.actualizar')->middleware('sesion.iniciada');
Route::delete('periodos/{periodo}', [PeriodoController::class,'eliminar'])->name('periodos.eliminar')->middleware('sesion.iniciada');
