<?php

use App\Http\Controllers\API\V1\AssignRoleController;
use App\Http\Controllers\API\V1\CountryController;
use App\Http\Controllers\API\V1\RevokeRoleController;
use App\Http\Controllers\API\V1\RolesController;
use App\Http\Controllers\API\V1\UsersController;
use App\Http\Controllers\Auth\TokenController;
use App\Models\ClassHierarchy;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->middleware('auth:sanctum')->group(function ($router) {
    $router->post('/users/assign-role/{user_id}', AssignRoleController::class);
    $router->post('/users/revoke-role/{user_id}', RevokeRoleController::class);
    $router->get('/users', [UsersController::class, 'index']);
    $router->get('/users/{id}', [UsersController::class, 'show']);
    $router->post('/users', [UsersController::class, 'store']);
    $router->apiResource('roles', RolesController::class);
    $router->apiResource('country', CountryController::class);
});

Route::post('/sanctum/token', [TokenController::class, 'store']);
Route::post('/sanctum/token-revoke', [TokenController::class, 'destroy']);
