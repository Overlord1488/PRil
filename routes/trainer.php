<?php

use App\Http\Controllers\Trainer\BookingController;
use App\Http\Controllers\Trainer\DashboardController;
use App\Http\Controllers\Trainer\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:trainer,admin'])->prefix('trainer')->name('trainer.')->group(function () {
    Route::get('/', DashboardController::class)->name('index');

    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');

    Route::get('/schedule/exceptions', [ScheduleController::class, 'exceptions'])->name('schedule.exceptions');
    Route::post('/schedule/exceptions', [ScheduleController::class, 'storeException'])->name('schedule.exceptions.store');
    Route::delete('/schedule/exceptions/{exception}', [ScheduleController::class, 'destroyException'])->name('schedule.exceptions.destroy');

    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{booking}/complete', [BookingController::class, 'complete'])->name('bookings.complete');
    Route::post('/bookings/{booking}/no-show', [BookingController::class, 'noShow'])->name('bookings.no-show');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});
