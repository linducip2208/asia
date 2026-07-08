<?php

use App\Http\Controllers\Tenant\RegisterController;
use App\Http\Controllers\Tenant\PlansController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [RegisterController::class, 'show'])->name('tenant.register');
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/plans', [PlansController::class, 'index'])->name('tenant.plans');
