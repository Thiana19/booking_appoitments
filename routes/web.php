<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;

Route::get('/', function () {
    return view('appointments/create');
});

Route::get('/appointments/create', function () {
    return view('appointments/create');
})->name('appointments/create');


Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

Route::get('/dashboard', [AppointmentController::class, 'index'])->name('dashboard');

Route::get('/login', 'App\Http\Controllers\Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/login', 'App\Http\Controllers\Auth\AdminLoginController@login')->name('admin.login.submit');

Route::post('/appointments/{appointment}/update-status', 'AppointmentController@updateStatus');

Route::post('/appointments/{appointment}/update-status', [AppointmentController::class, 'updateStatus'])
    ->name('appointments.updateStatus');