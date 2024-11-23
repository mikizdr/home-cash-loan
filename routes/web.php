<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdvisorController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\EnsureAdvisorOwnsClient;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function (): void {
    // Dashboard route.
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware(EnsureAdvisorOwnsClient::class)->group(function (): void {
        // Routes for manipulating with clients.
        Route::resource('/clients', AdvisorController::class)->except('show');
        Route::post('/clients/{client}/loan-cash', [AdvisorController::class, 'loanCash'])->name('clients.loan.cash');
        Route::post('/clients/{client}/loan-home', [AdvisorController::class, 'loanHome'])->name('clients.loan.home');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
