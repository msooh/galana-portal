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

Route::prefix('retail')->group(function() {
    Route::get('/', [RetailController::class, 'index'])->name('retail.index');    
    Route::resource('surveys', SurveyController::class);
    Route::resource('checklists', ChecklistController::class)->middleware('can:manage_checklists');
    Route::resource('categories', CategoryController::class);
    Route::resource('subcategories', SubcategoryController::class);
    Route::post('/surveys/{survey}/approve', [SurveyController::class, 'approve'])->name('surveys.approve');
});
