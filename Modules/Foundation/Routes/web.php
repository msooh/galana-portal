<?php

use Illuminate\Support\Facades\Route;
use Modules\Foundation\Http\Controllers\FoundationController;
use Modules\Foundation\Http\Controllers\SchoolController;
use Modules\Foundation\Http\Controllers\StudentController;
use Modules\Foundation\Http\Controllers\FeeController;
use Modules\Foundation\Http\Controllers\PerformanceController;
use Modules\Foundation\Http\Controllers\BankDetailController;

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
    Route::prefix('foundation')->group(function() {
        Route::get('/', [FoundationController::class, 'index'])->name('foundation.dashboard');
        // School Routes
        Route::resource('schools', SchoolController::class);

        // Student Routes
        Route::resource('students', StudentController::class);

        // Fees Routes
        Route::resource('fees', FeeController::class);

        // Performance Routes
        Route::resource('performances', PerformanceController::class);

        // Bank Details Routes
        Route::resource('bank-details', BankDetailController::class);
    });
});
