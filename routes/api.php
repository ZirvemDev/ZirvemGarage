<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SbmController;
use App\Http\Controllers\Api\LogController;
use App\Http\Controllers\Api\RolePermissionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/sanctum/token', TokenController::class);

Route::middleware(['auth:sanctum', 'apply_locale'])->group(function () {

    /**
     * Auth related
     */
    Route::get('/users/auth', AuthController::class);

    /**
     * Users
     */
    Route::put('/users/{user}/avatar', [UserController::class, 'updateAvatar']);
    Route::resource('users', UserController::class);
    Route::resource('garages', \App\Http\Controllers\VehicleController::class);

    /**
     * Roles
     */
    Route::get('/roles/search', [RoleController::class, 'search'])->middleware('throttle:400,1');

    Route::get('/sbm', [SbmController::class, 'index']);
    Route::post('/sbm/plate', [SbmController::class, 'plateQuery']);
    Route::get('/sbm/old', [SbmController::class, 'oldQuery']);
    Route::post('/sbm/fetch-data-by-plate', [SbmController::class, 'fetchDataByPlate']);

    Route::get('/logs', [LogController::class, 'index']);

    Route::prefix('roles')->group(function () {
        Route::get('/', [RolePermissionController::class, 'getRoles']);
        Route::post('/', [RolePermissionController::class, 'createRole']);
        Route::get('/abilities', [RolePermissionController::class, 'getAbilities']);
        Route::get('/{id}/abilities', [RolePermissionController::class, 'getRoleAbilities']);
        Route::post('/{id}/abilities', [RolePermissionController::class, 'syncRoleAbilities']);
        Route::put('/{id}', [RolePermissionController::class, 'updateRole']);
        Route::delete('/{id}', [RolePermissionController::class, 'deleteRole']);
    });

});
Route::post('/garage/addVehicle', [\App\Http\Controllers\VehicleController::class, 'store']);

