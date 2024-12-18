<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use Modules\Foundation\Http\Controllers\PerformanceController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/performances', [PerformanceController::class, 'display'])->name('performances');

// Uncomment the following routes if needed for testing or development
// Route::get('/migrate', function () {
//     Artisan::call('migrate');
//     return 'Migrations have been run';
// });
// Route::get('/test-file', function () {
//     return response()->file(storage_path('app/public/police_files/1718805390_avatar.jpg'));
// });
// Route::get('/create-storage-link', function () {
//     $exitCode = Artisan::call('storage:link');
//     return 'Storage link created!';
// });

foreach (glob(base_path('Modules/*/Routes/web.php')) as $routeFile) {
    require $routeFile;
}

Auth::routes();

// Group routes that require authentication and permissions
Route::middleware(['auth'])->group(function () {   
    
    // User management routes
    Route::middleware('permission:Manage Users')->group(function () {
        Route::resource('users', UserController::class);        
    });

     // Permission management routes
    Route::middleware('permission:Manage Permissions')->group(function () {
        Route::resource('permissions', PermissionController::class);
        Route::post('/permissions/assign', [PermissionController::class, 'assign'])->name('permissions.assign');
    });
    
    // User activation and deactivation routes
    Route::middleware('permission:Deactivate Users')->group(function () {
        Route::put('users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
    });
    Route::middleware('permission:Activate Users')->group(function () {
        Route::put('users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
    });
    // Role management routes
    Route::middleware('permission:Manage Roles')->group(function () {
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');       
        Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
    });
});
