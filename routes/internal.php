<?php

use App\Http\Controllers\Internal\Controls\MarkerCoverageController;
use App\Http\Controllers\Internal\Constructors\PanelStudioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('internal.index');
})->name('internal.index');

Route::get('/controls/markers', [MarkerCoverageController::class, 'index'])
    ->name('internal.controls.markers.index');

Route::name('internal.')->group(function () {
    Route::get('/panels', [PanelStudioController::class, 'index'])
        ->name('panels.index');

    Route::get('/panels/{panel}', [PanelStudioController::class, 'show'])
        ->name('panels.show');

    Route::get('/panels/{panel}/sections/{section}', [PanelStudioController::class, 'section'])
        ->name('panels.sections.show');
});