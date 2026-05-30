<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnalyzeController;
use App\Http\Controllers\ChecklistController;

Route::post('/analyze', [AnalyzeController::class, 'analyze']);
Route::get('/checklist', [ChecklistController::class, 'index']);
Route::get('/analyses/{id}', [AnalyzeController::class, 'show']);
