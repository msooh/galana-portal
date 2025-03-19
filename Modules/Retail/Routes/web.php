<?php


use Illuminate\Support\Facades\Route;
use Modules\Retail\Http\Controllers\RetailController;
use Modules\Retail\Http\Controllers\SurveyController;
use Modules\Retail\Http\Controllers\ChecklistController;
use Modules\Retail\Http\Controllers\CategoryController;
use Modules\Retail\Http\Controllers\SubcategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::middleware('permission:Retail Module')->group(function() {
        Route::get('retail/surveys/continue', [SurveyController::class, 'incompleteSurvey'])->name('surveys.continue');
        Route::prefix('retail')->group(function() {
            Route::get('/', [RetailController::class, 'index'])->name('retail.index');    
            Route::get('/surveys/create/{category}', [SurveyController::class, 'create'])->name('surveys.create');
            Route::post('/survey/save-or-submit', [SurveyController::class, 'saveOrSubmit'])->name('survey.saveOrSubmit');
            Route::resource('surveys', SurveyController::class)->except(['create']); 
            Route::middleware('permission:Manage Checklists')->group(function() {
                Route::resource('checklists', ChecklistController::class);
                Route::resource('categories', CategoryController::class);
                Route::resource('subcategories', SubcategoryController::class);
            });
            Route::middleware('permission:Create Survey')->group(function() {
                Route::post('/surveys/{survey}/approve', [SurveyController::class, 'approve'])->name('surveys.approve');
            });            
        });
    });
});
