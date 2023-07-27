<?php
use App\Http\Controllers\RepInscritoController;

Route::get('rep_inscritos', [RepInscritoController::class,'index'])->name('rep_inscritos.index')->middleware('sesion.iniciada');
Route::post('rep_inscritos', [RepInscritoController::class,'index'])->name('rep_inscritos.index')->middleware('sesion.iniciada');
