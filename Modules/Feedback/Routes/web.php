<?php

use Illuminate\Support\Facades\Route;
use Modules\Feedback\Http\Controllers\FeedbackController;
use Modules\Feedback\Http\Controllers\CustomerFeedbackController;

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
Route::get('/galana-virtual-feedback', [FeedbackController::class, 'staff'])->name('feedback.staff');
Route::post('/staff-feedback-submit', [FeedbackController::class, 'submit'])->name('feedback.submit');
Route::prefix('customer-feedback')->group(function() {    
    Route::get('/', [FeedbackController::class, 'index'])->name('feedback.dashboard');
    Route::get('/staff-feedback', [FeedbackController::class, 'staffList'])->name('staff-feedback.list');
    Route::resource('feedback', CustomerFeedbackController::class);
   
});
