<?php

use Illuminate\Support\Facades\Route;
use Modules\HSSEQ\Http\Controllers\SafetyController;
use Modules\HSSEQ\Http\Controllers\HSSEQController;

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

Route::prefix('hsseq')->group(function() {
    Route::get('/', [HSSEQController::class, 'index'])->name('hsseq.dashboard');
    Route::resource('hsseq', SafetyController::class)->middleware('can:manage_safeties');
    Route::post('/safety/{report}/assign-task', [SafetyController::class, 'assignTask'])->name('safety.assignTask');
    Route::get('/safeties/pending', [SafetyController::class, 'pendingSafeties'])->name('safeties.pending');
    Route::post('/safeties/close-task/{id}', [SafetyController::class, 'closeTask'])->name('safeties.closeTask');
    Route::get('/safeties/closed-tasks', [SafetyController::class, 'closedTasks'])->name('safeties.closedTasks');
});
