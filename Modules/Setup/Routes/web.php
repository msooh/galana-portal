<?php
use Illuminate\Support\Facades\Route;
use Modules\Setup\Http\Controllers\DealerController;
use Modules\Setup\Http\Controllers\StationController;
use Modules\Setup\Http\Controllers\StationManagerController;
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

Route::prefix('setup')->group(function() {
    Route::get('/', 'SetupController@index');
    Route::resource('dealers', DealerController::class)->middleware('can:manage_dealers');
    Route::resource('stations', StationController::class)->middleware('can:manage_stations');
    Route::resource('station_managers', StationManagerController::class)->middleware('can:manage_station_managers');
    Route::patch('dealers/{id}/deactivate', [DealerController::class, 'deactivate'])->name('setup::dealers.deactivate');
    Route::patch('dealers/{id}/activate', [DealerController::class, 'activate'])->name('setup::dealers.activate');
    Route::patch('station-managers/{id}/deactivate', [StationManagerController::class, 'deactivate'])->name('setup::station_managers.deactivate');
    Route::patch('station-managers/{id}/activate', [StationManagerController::class, 'activate'])->name('setup::station_managers.activate');
    Route::post('/station_managers/{manager}/assign_station', [StationManagerController::class, 'assignStation'])->name('station_managers.assign_station');
    Route::patch('/station-managers/{id}/reassign-station', [StationManagerController::class, 'reassignStation'])->name('station_managers.reassign_station');

    Route::resource('locations', LocationController::class)->middleware('can:manage_stations');;

});
