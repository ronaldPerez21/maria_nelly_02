<?php
use App\Http\Controllers\RepNotaController;

Route::get('rep_notas', [RepNotaController::class,'index'])->name('rep_notas.index')->middleware('sesion.iniciada');
Route::post('rep_notas', [RepNotaController::class,'index'])->name('rep_notas.index')->middleware('sesion.iniciada');
