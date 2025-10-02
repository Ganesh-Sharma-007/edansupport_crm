<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{
    LoginController,
    LogoutController,
    ProfileController,
    NotificationController
};
use App\Http\Controllers\{
    DashboardController,
    UserController,
    EmployeeController,
    ServiceUserController,
    FunderController,
    RosteringController,
    TimesheetController,
    InvoiceController,
    SettingController
};

/* ---------- Authentication ---------- */
Route::middleware('guest')->group(function () {
    Route::get('login',  [LoginController::class, 'show'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});

Route::post('logout', [LogoutController::class, 'destroy'])->name('logout');

/* ---------- Authenticated ---------- */
Route::middleware(['auth'])->group(function () {

    /* Profile & Notifications */
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');

    /* Dashboard */
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    /* Users */
    Route::middleware('role:super-admin,admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });

    /* Employees */
    Route::resource('employees', EmployeeController::class)->except(['show']);

    /* Service Users */
    Route::resource('service-users', ServiceUserController::class)->except(['show']);

    /* Funders */
    Route::resource('funders', FunderController::class)->except(['show']);

    /* Rostering */
    Route::controller(RosteringController::class)->prefix('rostering')->name('rostering.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/calendar', 'calendar')->name('calendar');
        Route::post('/store', 'store')->name('store');
        Route::put('/{roster}', 'update')->name('update');
        Route::delete('/{roster}', 'destroy')->name('destroy');
    });

    /* Timesheets */
    Route::get('timesheets', [TimesheetController::class, 'index'])->name('timesheets.index');

    /* Invoices */
    Route::controller(InvoiceController::class)->prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/generate', 'generate')->name('generate');
        Route::get('/{invoice}', 'show')->name('show');
        Route::delete('/{invoice}', 'destroy')->name('destroy');
    });

    /* Settings (super-admin only) */
    Route::middleware('role:super-admin')->prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('permissions/{user}', [SettingController::class, 'updatePermissions'])->name('permissions.update');
        Route::resource('holidays', \App\Http\Controllers\HolidayController::class)->except(['show']);
    });
});