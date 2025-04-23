<?php

use App\Http\Controllers\Api\Job\JobController;
use Illuminate\Support\Facades\Route;

Route::prefix('jobs')->as('jobs.')->group(function () {
    Route::get('/', [JobController::class, 'index'])->name('index');
});
