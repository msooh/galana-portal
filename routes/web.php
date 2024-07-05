<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StationManagerController;
use App\Http\Controllers\UserController;


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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*Route::get('/migrate', function () {
    Artisan::call('migrate');
    return 'Migrations have been run';
});
Route::get('/test-file', function () {
    return response()->file(storage_path('app/public/police_files/1718805390_avatar.jpg'));
});

Route::get('/create-storage-link', function () {
    $exitCode = Artisan::call('storage:link');
    return 'Storage link created!';
});
*/

foreach (glob(base_path('Modules/*/Routes/web.php')) as $routeFile) {
    require $routeFile;
}


Auth::routes();

Route::middleware(['auth'])->group(function () {    
    Route::resource('users', UserController::class)->middleware('can:manage_users');
    Route::put('users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
    Route::put('users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');    

});


