<?php

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

Route::group(['middleware' => ['respond.json']], function () {
    Route::post('login', [\App\Http\Controllers\Api\Auth\LoginController::class, 'login']);
    Route::post('register', [\App\Http\Controllers\Api\Auth\RegisterController::class, 'register']);
    Route::post('token/refresh', [\App\Http\Controllers\Api\Auth\TokenController::class, 'refresh']);
    Route::post('password/email', [\App\Http\Controllers\Api\Auth\ForgotPasswordController::class, 'sendResetCodeEmail']);
    Route::post('password/phone', [\App\Http\Controllers\Api\Auth\ForgotPasswordController::class, 'sendResetCodePhone']);
    Route::post('password/reset', [\App\Http\Controllers\Api\Auth\ResetPasswordController::class, 'reset']);
    //    Route::post('password/reset', 'Auth\ResetPasswordController.php@reset');
    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [\App\Http\Controllers\Api\Auth\LoginController::class, 'logout']);
        Route::get('profile', [\App\Http\Controllers\Api\ProfileController::class, 'index']);
        Route::put('profile', [\App\Http\Controllers\Api\ProfileController::class, 'update']);
        Route::post('one_signal', \App\Http\Controllers\Api\OneSignalController::class);
        Route::get('my/inventory', \App\Http\Controllers\Api\MyInventoryController::class);
        Route::get('steps', \App\Http\Controllers\Api\StepsController::class);
        Route::get('application/history', \App\Http\Controllers\Api\ApplicationHistoryController::class);
        Route::get('application/unaccepted', \App\Http\Controllers\Api\ApplicationUnacceptedController::class);
        Route::post('application/{application}/accept', [\App\Http\Controllers\Api\ApplicationAcceptController::class, 'store']);
        Route::put('application/{application}/accept', [\App\Http\Controllers\Api\ApplicationAcceptController::class, 'update']);
        Route::get('application/{application}/start', \App\Http\Controllers\Api\StartingController::class);
        Route::post('application/{application}/start', [\App\Http\Controllers\Api\ProgressController::class, 'start']);
        Route::post('application/{application}/stocktakings', \App\Http\Controllers\Api\StartingStocktakingController::class);
        Route::get('application/{application}/defectives', [\App\Http\Controllers\Api\DefectiveController::class, 'index']);
        Route::post('application/{application}/defectives', [\App\Http\Controllers\Api\DefectiveController::class, 'store']);
        Route::post('application/{application}/measurements', [\App\Http\Controllers\Api\MeasurementController::class, 'store']);
        Route::post('application/{application}/preventive', [\App\Http\Controllers\Api\ProgressController::class, 'preventive']);
        Route::get('application/{application}/protocols/{starting}', [\App\Http\Controllers\Api\ProtocolController::class, 'index']);
        Route::post('application/{application}/protocols', [\App\Http\Controllers\Api\ProtocolController::class, 'store']);
        Route::post('application/{application}/keys', [\App\Http\Controllers\Api\ProgressController::class, 'keys']);
        Route::post('application/{application}/inventory', [\App\Http\Controllers\Api\ProgressController::class, 'inventory']);
        Route::post('application/{application}/arrived', [\App\Http\Controllers\Api\ProgressController::class, 'arrived']);
        Route::post('application/{application}/install', [\App\Http\Controllers\Api\ProgressController::class, 'install']);
        Route::post('application/{application}/report', [\App\Http\Controllers\Api\ProgressController::class, 'report']);
        Route::post('application/{application}/complete', [\App\Http\Controllers\Api\ProgressController::class, 'complete']);
        Route::post('application/{application}/comment', [\App\Http\Controllers\Api\CommentController::class, 'store']);
        Route::get('application/{application}/stations/{station}', \App\Http\Controllers\Api\ApplicationStationController::class);
        Route::apiResource('application/{application}/image', \App\Http\Controllers\Api\ImageController::class)
            ->only([
                'index',
                'store',
                'destroy'
            ]);
        Route::apiResource('application', \App\Http\Controllers\Api\ApplicationController::class)
            ->except([
                'destroy',
                'store'
            ]);
        Route::get('station/{station}/groups', \App\Http\Controllers\Api\GroupController::class);
        Route::get('station/{station}/groups/{group}/batteries', \App\Http\Controllers\Api\BatteryController::class);
        Route::get('station/{station}/sensors', \App\Http\Controllers\Api\SensorController::class);
        Route::get('station/{station}/stocktakings', \App\Http\Controllers\Api\StocktakingController::class);
        Route::apiResource('station', \App\Http\Controllers\Api\StationController::class)
            ->only([
                'index',
                'show'
            ]);
        Route::apiResource('inventory', \App\Http\Controllers\Api\InventoryController::class)
            ->except([
                'update',
                'destroy'
            ]);
        Route::apiResource('user', \App\Http\Controllers\Api\UserController::class)
            ->except([
                'destroy'
            ]);
        Route::get('routes/history', \App\Http\Controllers\Api\RouteHistoryController::class);
        Route::post('route/{route}/location', \App\Http\Controllers\Api\RouteLocationController::class);
        Route::post('route/{route}/active', [\App\Http\Controllers\Api\ActivityController::class, 'active']);
        Route::post('route/{route}/pause', [\App\Http\Controllers\Api\ActivityController::class, 'pause']);
        Route::post('route/{route}/closed', [\App\Http\Controllers\Api\ActivityController::class, 'closed']);
        Route::post('route/{route}/completed', [\App\Http\Controllers\Api\ActivityController::class, 'completed']);
        Route::post('route/{route}/application', [\App\Http\Controllers\Api\ApplicationRouteController::class, 'store'])
            ->name('route.application.store');
        Route::delete('route/{route}/application/{application}', [\App\Http\Controllers\Api\ApplicationRouteController::class, 'destroy'])
            ->name('route.application.delete');
        Route::apiResource('route', \App\Http\Controllers\Api\RouteController::class)
            ->except([
                'destroy'
            ]);

        Route::apiResource('addresses', \App\Http\Controllers\Api\AddressController::class)
            ->only([
                'index'
            ]);

        Route::get('category', \App\Http\Controllers\Api\CategoryController::class);
        Route::get('division', \App\Http\Controllers\Api\DivisionController::class);
        Route::get('areas', \App\Http\Controllers\Api\AreaController::class);
        Route::get('state', \App\Http\Controllers\Api\StateController::class);
        Route::get('region', \App\Http\Controllers\Api\RegionController::class);
        Route::get('city', \App\Http\Controllers\Api\CityController::class);
        Route::get('work', \App\Http\Controllers\Api\WorkController::class);
        Route::get('types', [\App\Http\Controllers\Api\TypeController::class, 'index']);
        Route::get('types/{type}', [\App\Http\Controllers\Api\TypeController::class, 'show']);
        Route::get('progress_types', [\App\Http\Controllers\Api\ProgressTypeController::class, 'index']);
        Route::get('progress_types/{type}', [\App\Http\Controllers\Api\ProgressTypeController::class, 'show']);
        Route::get('project', \App\Http\Controllers\Api\ProjectController::class);
        Route::get('position', \App\Http\Controllers\Api\PositionController::class);
        Route::get('role', \App\Http\Controllers\Api\RoleController::class);
        Route::get('status', \App\Http\Controllers\Api\StatusController::class);
        Route::get('consumables', \App\Http\Controllers\Api\ConsumableController::class);
        Route::get('places', \App\Http\Controllers\Api\PlaceController::class);
        Route::get('vehicle_types', \App\Http\Controllers\Api\VehicleTypeController::class);
        Route::get('vehicles', \App\Http\Controllers\Api\VehicleController::class);
        Route::get('document', \App\Http\Controllers\Api\DocumentController::class);
    });
});
