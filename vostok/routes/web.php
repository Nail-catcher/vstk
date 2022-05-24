<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('login');
})->name('index');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('one_signal', \App\Http\Controllers\OneSignalController::class)
        ->name('one_signal');

    Route::get('dashboard', \App\Http\Controllers\DashboardController::class)
        ->name('dashboard');

    Route::get('station/map', \App\Http\Controllers\StationMapController::class)
        ->name('station.map');
    Route::get('station/{station}/application', \App\Http\Controllers\ApplicationStationController::class)
        ->name('station.application');
    Route::resource('station', \App\Http\Controllers\StationController::class);

    Route::post('application/import', \App\Http\Controllers\ApplicationImportController::class)
        ->name('application.import');
    Route::post('application/approval', \App\Http\Controllers\ApplicationApprovalController::class)
        ->name('application.approval');
    Route::get('application/type/{type}', [\App\Http\Controllers\TypeController::class, 'show'])
        ->name('application.type.show');
    Route::get('application/area/{area}', [\App\Http\Controllers\AreaController::class, 'show'])
        ->name('application.area.show');
    Route::get('application/history', \App\Http\Controllers\ApplicationHistoryController::class)
        ->name('application.history');
    Route::post('application/{application}/comment', [\App\Http\Controllers\CommentController::class, 'store'])
        ->name('comment.store');
    Route::resource('application', \App\Http\Controllers\ApplicationController::class);

    Route::put('user/{user}/status', \App\Http\Controllers\UserStatusController::class)
        ->name('user.status');
    Route::resource('user', \App\Http\Controllers\UserController::class);

    Route::get('inventory/history', \App\Http\Controllers\InventoryHistoryController::class)
        ->name('inventory.history');
    Route::get('inventory/history/inventory.xlsx', \App\Http\Controllers\InventoryHistoryDownloadController::class)
        ->name('inventory.history.download');
    Route::get('inventory/tmz', \App\Http\Controllers\InventoryQrController::class)
        ->name('inventory.tmz');
    Route::resource('inventory', \App\Http\Controllers\InventoryController::class);

    Route::get('routes/history', \App\Http\Controllers\RouteHistoryController::class)
        ->name('route.history');
    Route::post('route/{route}/application', [\App\Http\Controllers\ApplicationRouteController::class, 'store'])
        ->name('route.application.store');
    Route::post('route/{route}/closed', [\App\Http\Controllers\RouteClosedController::class, 'store'])
        ->name('route.closed');
    Route::delete('route/{route}/application/{application}', [\App\Http\Controllers\ApplicationRouteController::class, 'destroy'])
        ->name('route.application.delete');
    Route::post('route/{route}/approval', \App\Http\Controllers\RouteApprovalController::class)
        ->name('route.approval');
    Route::resource('route', \App\Http\Controllers\RouteController::class);

    Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])
        ->name('reports.index');
    Route::get('reports/workload.xlsx', [\App\Http\Controllers\ReportController::class, 'workload'])->name('reports.workload');
    Route::get('reports/workdoneAVR.xlsx', [\App\Http\Controllers\ReportController::class, 'workdoneAVR'])->name('reports.workdoneAVR');
    Route::get('reports/workdone.xlsx', [\App\Http\Controllers\ReportController::class, 'workdone'])->name('reports.workdone');
    Route::get('reports/actDefect.xlsx', [\App\Http\Controllers\ReportController::class, 'actDefect'])->name('reports.actDefect');
    Route::get('reports/invertingSheet.xlsx', [\App\Http\Controllers\ReportController::class, 'invertingSheet'])->name('reports.invertingSheet');
    Route::get('reports/materialStatement.xlsx', [\App\Http\Controllers\ReportController::class, 'materialStatement'])->name('reports.materialStatement');
    Route::get('reports/acceptanceCertificate.xlsx', [\App\Http\Controllers\ReportController::class, 'acceptanceCertificate'])->name('reports.acceptanceCertificate');
    Route::get('reports/actReadingElector.xlsx', [\App\Http\Controllers\ReportController::class, 'actReadingElector'])->name('reports.actReadingElector');
    Route::get('reports/actDischarge.xlsx', [\App\Http\Controllers\ReportController::class, 'actDischarge'])->name('reports.actDischarge');
    Route::get('reports/reportOperatorPPR.xlsx', [\App\Http\Controllers\ReportController::class, 'reportOperatorPPR'])->name('reports.reportOperatorPPR');
    Route::get('reports/reportByAVRMTC.xlsx', [\App\Http\Controllers\ReportController::class, 'reportByAVRMTC'])->name('reports.reportByAVRMTC');
    Route::get('reports/reportAVR.xlsx', [\App\Http\Controllers\ReportController::class, 'reportAVR'])->name('reports.reportAVR');
    Route::get('reports/actEquipmentInstallation.xlsx', [\App\Http\Controllers\ReportController::class, 'actEquipmentInstallation'])->name('reports.actEquipmentInstallation');
    Route::resource('addresses', \App\Http\Controllers\AddressController::class);
    Route::resource('consumables', \App\Http\Controllers\ConsumableController::class);
    Route::resource('places', \App\Http\Controllers\PlaceController::class);
    Route::resource('vehicles', \App\Http\Controllers\VehicleController::class);

    Route::get('statistics', [\App\Http\Controllers\StatisticController::class, 'index'])
        ->name('statistics.index');
    Route::get('statistics/statistics-applications.xlsx', [\App\Http\Controllers\StatisticController::class, 'download'])
        ->name('statistics.applications');

    //TODO: Refactoring
    Route::get('history/actions', [\App\Http\Controllers\HistoryController::class, 'index'])
        ->name('history.index');
    Route::get('directory/auto', [\App\Http\Controllers\DirectoryController::class, 'auto'])
        ->name('directory.auto');
    Route::get('directory/material', [\App\Http\Controllers\DirectoryController::class, 'material'])
        ->name('directory.material');

    Route::prefix('web-api')->group(function () {
        Route::get('area', \App\Http\Controllers\Web\AreaController::class)
            ->name('api.area.index');
        Route::get('addresses', \App\Http\Controllers\Web\AddressController::class)
            ->name('api.addresses.index');
        Route::get('places', \App\Http\Controllers\Web\PlaceController::class)
            ->name('api.places.index');
        Route::get('vehicles', \App\Http\Controllers\Web\VehicleController::class)
            ->name('api.vehicles.index');
        Route::get('vehicle_types', \App\Http\Controllers\Web\VehicleTypeController::class)
            ->name('api.vehicle_types.index');
        Route::get('divisions', \App\Http\Controllers\Web\DivisionController::class)
            ->name('api.division.index');
        Route::get('priority', \App\Http\Controllers\Web\PriorityController::class)
            ->name('api.priority.index');
        Route::get('application', [\App\Http\Controllers\Web\ApplicationController::class, 'index'])
            ->name('api.application.index');
        Route::get('application/workload', \App\Http\Controllers\Web\WorkloadController::class)
            ->name('api.application.workload');
        Route::get('application/{application}', [\App\Http\Controllers\Web\ApplicationController::class, 'show'])
            ->name('api.application.show');
        Route::get('station', \App\Http\Controllers\Web\StationController::class)
            ->name('api.station.index');
        Route::get('route/{route}', \App\Http\Controllers\Web\RouteController::class)
            ->name('api.route.show');
        Route::get('route/{route}/locations', \App\Http\Controllers\Web\RouteLocationController::class)
            ->name('api.route.locations');
        Route::get('user', \App\Http\Controllers\Web\UserController::class)
            ->name('api.user.index');
    });
});
