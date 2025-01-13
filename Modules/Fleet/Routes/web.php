<?php

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

use Illuminate\Support\Facades\Route;
use Modules\Fleet\Http\Controllers\FleetController;
use Modules\Fleet\Http\Controllers\DriverController;
use Modules\Fleet\Http\Controllers\LicenseController;
use Modules\Fleet\Http\Controllers\VehicleTypeController;
use Modules\Fleet\Http\Controllers\FuelTypeController;
use Modules\Fleet\Http\Controllers\RecurringController;
use Modules\Fleet\Http\Controllers\MaintenanceTypeController;
use Modules\Fleet\Http\Controllers\CustomerController;
use Modules\Fleet\Http\Controllers\VehicleController;
use Modules\Fleet\Http\Controllers\InsuranceController;
use Modules\Fleet\Http\Controllers\FuelController;
use Modules\Fleet\Http\Controllers\BookingController;
use Modules\Fleet\Http\Controllers\MaintenanceController;
use Modules\Fleet\Http\Controllers\AvailabilityController;

Route::group(['middleware' => 'PlanModuleCheck:Fleet'], function ()
{
    Route::middleware(['auth','verified'])->group(function () {

        Route::prefix('fleet')->group(function() {
            Route::get('/', 'FleetController@index');
        });

    Route::get('dashboard/fleet',[FleetController::class,'index'])->name('fleet.dashboard');

    Route::resource('driver', 'DriverController');
    Route::resource('license', 'LicenseController');
    Route::resource('vehicleType', 'VehicleTypeController');
    Route::resource('fuelType', 'FuelTypeController');
    Route::resource('recuerring', 'RecurringController');
    Route::resource('maintenanceType', 'MaintenanceTypeController');
    Route::resource('fleet_customer', 'CustomerController');
    Route::resource('vehicle', 'VehicleController');
    Route::resource('insurance', 'InsuranceController');
    Route::resource('fuel', 'FuelController');
    Route::resource('booking', 'BookingController');

    Route::get('driver-grid', [DriverController::class,'grid'])->name('driver.grid');
    Route::get('Addpayment/{id}', [BookingController::class,'Addpayment'])->name('Addpayment.create');
    Route::post('Addpayment/store/{id}', [BookingController::class,'PaymentStore'])->name('Addpayment.store');
    Route::DELETE('payment/destory/{id}/', [BookingController::class,'PaymentDestory'])->name('payment.delete');

    Route::resource('maintenance', 'MaintenanceController');
    Route::resource('availability', 'AvailabilityController');

    });
});
