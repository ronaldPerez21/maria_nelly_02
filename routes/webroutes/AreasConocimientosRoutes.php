<?php
use App\Http\Controllers\AreaConocimientoController;

Route::get('areas-conocimientos', [AreaConocimientoController::class,'index'])->name('areas_conocimientos.index')->middleware('sesion.iniciada');
Route::get('areas-conocimientos/agregar', [AreaConocimientoController::class,'agregar'])->name('areas_conocimientos.agregar')->middleware('sesion.iniciada');
Route::get('areas-conocimientos/{id}', [AreaConocimientoController::class,'mostrar'])->name('areas_conocimientos.mostrar')->middleware('sesion.iniciada');
Route::post('areas-conocimientos', [AreaConocimientoController::class,'insertar'])->name('areas_conocimientos.insertar')->middleware('sesion.iniciada');
Route::get('areas-conocimientos/{id}/modificar', [AreaConocimientoController::class,'modificar'])->name('areas_conocimientos.modificar')->middleware('sesion.iniciada');
Route::put('areas-conocimientos/{area_conocimiento}', [AreaConocimientoController::class,'actualizar'])->name('areas_conocimientos.actualizar')->middleware('sesion.iniciada');
Route::delete('areas-conocimientos/{area_conocimiento}', [AreaConocimientoController::class,'eliminar'])->name('areas_conocimientos.eliminar')->middleware('sesion.iniciada');
