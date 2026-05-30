<?php


use App\Models\Marker;
use App\Models\MarkerGroup;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\MarkerController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\UploadedDocumentController;


Route::get('/', function () {
    return view('home.index');
});

Route::get('/analyze-ui', function () {
return view('analyze.index');
});

Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
Route::get('/plans/{slug}', [PlanController::class, 'show'])->name('plans.show');
Route::post('/plans/{slug}/add', [PlanController::class, 'addToMyPlan'])
    ->name('plans.add');


    
Route::get('/markers', [MarkerController::class, 'index'])->name('markers.index');

Route::get('/markers/az', [MarkerController::class, 'az'])->name('markers.az');

Route::get('/markers/groups/{groupSlug}', [MarkerController::class, 'group'])->name('markers.group');

Route::get('/markers/{slug}', [MarkerController::class, 'show'])->name('markers.show');



Route::get('/my-checklist', [ChecklistController::class, 'myChecklist']);

Route::get('/search', [SearchController::class, 'index'])->name('search.index');




Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/documents', [UploadedDocumentController::class, 'index'])
    ->name('documents.index');

Route::get('/documents/{document}', [UploadedDocumentController::class, 'show'])
    ->name('documents.show');

    Route::get('/my-checklist', [ChecklistController::class, 'myChecklist'])
    ->name('checklist.index');

Route::get('/my-checklist/plans', [ChecklistController::class, 'plans'])
    ->name('checklist.plans');

Route::get('/my-checklist/dynamics', [ChecklistController::class, 'dynamics'])
    ->name('checklist.dynamics');

Route::get('/my-checklist/dynamics/{marker}', [ChecklistController::class, 'dynamicShow'])
    ->name('checklist.dynamics.show');

Route::get('/my-checklist/uploads', [ChecklistController::class, 'uploads'])
    ->name('checklist.uploads');

Route::get('/my-checklist/uploads/{document}', [ChecklistController::class, 'uploadShow'])
    ->name('checklist.uploads.show');

Route::get('/my-checklist/profile', [ChecklistController::class, 'profile'])
    ->name('checklist.profile');