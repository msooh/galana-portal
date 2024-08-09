<?php
use Illuminate\Support\Facades\Route;
use Modules\Setup\Http\Controllers\DealerController;
use Modules\Setup\Http\Controllers\StationController;
use Modules\Setup\Http\Controllers\StationManagerController;
use Modules\Setup\Http\Controllers\TerritoryManagerController;
use Modules\Setup\Http\Controllers\LocationController;
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
    Route::prefix('setup')->group(function() {
        Route::get('/', [SetupController::class, 'index'])->name('setup.index');
        
        Route::middleware('permission:Manage Dealers')->group(function() {
            Route::resource('dealers', DealerController::class);
            Route::patch('dealers/{id}/deactivate', [DealerController::class, 'deactivate'])->name('setup::dealers.deactivate');
            Route::patch('dealers/{id}/activate', [DealerController::class, 'activate'])->name('setup::dealers.activate');
        });
        
        Route::middleware('permission:Manage Stations')->group(function() {
            Route::resource('stations', StationController::class);
            Route::resource('locations', LocationController::class);
        });

        Route::middleware('permission:Manage Station Managers')->group(function() {
            Route::resource('station_managers', StationManagerController::class);
            Route::patch('station-managers/{id}/deactivate', [StationManagerController::class, 'deactivate'])->name('setup::station_managers.deactivate');
            Route::patch('station-managers/{id}/activate', [StationManagerController::class, 'activate'])->name('setup::station_managers.activate');
            Route::post('station_managers/{manager}/assign_station', [StationManagerController::class, 'assignStation'])->name('station_managers.assign_station');
            Route::patch('station-managers/{id}/reassign-station', [StationManagerController::class, 'reassignStation'])->name('station_managers.reassign_station');
        });
        Route::middleware('permission:Manage Territory Managers')->group(function() {
            Route::resource('territory_managers', TerritoryManagerController::class);
            Route::patch('territory-managers/{id}/deactivate', [TerritoryManagerController::class, 'deactivate'])->name('setup::territory_managers.deactivate');
            Route::patch('territory-managers/{id}/activate', [TerritoryManagerController::class, 'activate'])->name('setup::territory_managers.activate');
            Route::post('territory_managers/{manager}/assign_station', [TerritoryManagerController::class, 'assignStation'])->name('territory_managers.assign_station');
            Route::patch('territory-managers/{id}/reassign-station', [TerritoryManagerController::class, 'reassignStation'])->name('territory_managers.reassign_station');
        });
    });
});