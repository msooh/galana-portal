<?php
use Illuminate\Support\Facades\Route;
use Modules\Suggestion\Http\Controllers\SuggestionController;

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
Route::get('/thank-you', function () {
    return view('suggestion::thankyou');
})->name('suggestion.thankyou');

Route::middleware(['auth'])->group(function () {
    Route::middleware('permission:Suggestions Module')->group(function() {
        Route::prefix('suggestion')->group(function() {
            Route::get('/', 'SuggestionController@index');
            Route::get('/dashboard', [SuggestionController::class, 'dashboard'])->name('suggestions.dashboard');
            Route::get('/history', [SuggestionController::class, 'history'])->name('suggestions.history');
            Route::post('/submit', [SuggestionController::class, 'store'])->name('suggestion.store');
        });
    });
});